<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Finance\Entities\ClosingBalance;
use Modules\Finance\Entities\DepositeAmount;
use Modules\Finance\Entities\PaymentVerification;

class DailyCollectionController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    //  INDEX
    // ─────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $date    = $request->input('date') ?? Carbon::today()->toDateString();
        $isToday = $date === Carbon::today()->toDateString();

        // Auto-repair: fix any closing_balance rows where cash_amount=0
        // but the actual payment_verifications show cash payments.
        // This silently corrects bad legacy data on first page load.
        $this->repairClosingBalances();

        $alreadyClosed = ClosingBalance::whereDate('date', $date)->exists();
        $todayClosing  = ClosingBalance::whereDate('date', $date)->first();

        // ── Opening Balance ────────────────────────────────────────
        // Net undeposited cash from ALL previous pending closing days.
        $openingBalance  = 0;
        $pendingBefore   = ClosingBalance::where('status', 'pending')
            ->whereDate('date', '<', $date)
            ->get();
        foreach ($pendingBefore as $pc) {
            $dep = DepositeAmount::where('closing_balance_id', $pc->id)->sum('amount');
            $openingBalance += max(0, (float)$pc->cash_amount - (float)$dep);
        }

        // ── Today's collections ────────────────────────────────────
        $collections = $this->getVerifiedByDate($date);
        $cashTotal   = $collections->where('payment_method', 'cash')->sum('paid_amount');
        $onlineTotal = $collections->where('payment_method', '!=', 'cash')->sum('paid_amount');
        $grandTotal  = $collections->sum('paid_amount');

        // ── Total cash still physically in hand (ALL pending days ≤ date) ──
        $cashStillInHand = 0;
        $allPending      = ClosingBalance::where('status', 'pending')
            ->whereDate('date', '<=', $date)
            ->get();
        foreach ($allPending as $pc) {
            $dep = DepositeAmount::where('closing_balance_id', $pc->id)->sum('amount');
            $cashStillInHand += max(0, (float)$pc->cash_amount - (float)$dep);
        }

        // If day not yet closed, cashStillInHand should include today's
        // undeposited cash (opening balance) + today's new cash
        if (!$alreadyClosed) {
            $cashStillInHand = $openingBalance + $cashTotal;
        }

        // ── Pending closings for deposit breakdown ─────────────────
        $pendingClosings = ClosingBalance::where('status', 'pending')
            ->whereDate('date', '<=', Carbon::today())
            ->orderBy('date')
            ->get()
            ->map(function ($pc) {
                $dep = DepositeAmount::where('closing_balance_id', $pc->id)->sum('amount');
                $pc->remaining = max(0, (float)$pc->cash_amount - (float)$dep);
                return $pc;
            })
            ->filter(fn($pc) => $pc->remaining > 0)
            ->values();

        return view('finance::dailycollection.index', compact(
            'collections', 'grandTotal', 'cashTotal', 'onlineTotal',
            'date', 'isToday', 'alreadyClosed', 'todayClosing',
            'openingBalance', 'cashStillInHand', 'pendingClosings'
        ));
    }

    // ─────────────────────────────────────────────────────────────
    //  AUTO-REPAIR: Fix closing_balance rows where cash_amount = 0
    //  but actual payment_verifications show cash was collected.
    //  Safe to run on every request — only updates stale rows.
    // ─────────────────────────────────────────────────────────────
    private function repairClosingBalances(): void
    {
        $broken = ClosingBalance::where('cash_amount', 0)
            ->where('amount', '>', 0)
            ->get();

        foreach ($broken as $cb) {
            $dateStr = Carbon::parse($cb->date)->toDateString();

            $payments    = PaymentVerification::whereDate('payment_date', $dateStr)->get();
            $cashAmount  = $payments->where('payment_method', 'cash')->sum('paid_amount');
            $totalAmount = $payments->sum('paid_amount');
            $onlineAmount = $totalAmount - $cashAmount;

            // Only update if we actually find cash payments for that day
            if ($cashAmount > 0) {
                $cb->update([
                    'cash_amount'   => $cashAmount,
                    'online_amount' => $onlineAmount,
                    'amount'        => $totalAmount,
                    // If there's cash, it should be pending (not deposited)
                    'status'        => $cb->status === 'deposited' ? 'deposited' : 'pending',
                ]);
            }
        }
    }

    // ─────────────────────────────────────────────────────────────
    //  CORE QUERY
    // ─────────────────────────────────────────────────────────────
    private function getVerifiedByDate(?string $date)
    {
        $query = PaymentVerification::with([
            'customer', 'customerPayment',
            'customerTicketPayment', 'ticket', 'branch',
        ]);

        if ($date) {
            $query->whereDate('payment_date', $date);
        }

        return $query->get()->map(function ($v) {
            $name = $v->customer_name;
            if ($v->type === 'Ticket') {
                $name = optional($v->ticket)->subject
                    ? 'Ticket #' . $v->ticket->id . ' — ' . $v->ticket->subject
                    : 'Ticket #' . ($v->ticket_id ?? 'N/A');
            }
            $reference = $v->type === 'Ticket'
                ? 'TKT-' . ($v->ticket_id ?? $v->id)
                : 'INST-' . ($v->customer_payment_id ?? $v->id);

            return (object)[
                'id'             => $v->id,
                'name'           => $name,
                'branch'         => optional($v->branch)->name ?? '—',
                'payment_method' => $v->payment_method,
                'payment_date'   => $v->payment_date,
                'paid_amount'    => $v->paid_amount,
                'amount'         => $v->paid_amount,
                'total_amount'   => $v->total_amount,
                'remaining'      => $v->remaining_amount,
                'message'        => $v->message ?? '—',
                'type'           => $v->type,
                'reference_no'   => $reference,
                'status'         => $v->status,
            ];
        })
        ->sortByDesc('payment_date')
        ->values();
    }

    // ─────────────────────────────────────────────────────────────
    //  STORE CLOSING AMOUNT
    // ─────────────────────────────────────────────────────────────
    public function storeClosingAmount(Request $request)
    {
        $date = Carbon::today()->toDateString();

        if (ClosingBalance::whereDate('date', $date)->exists()) {
            return redirect()->back()->with('error', 'Day already closed for today.');
        }

        $collections   = $this->getVerifiedByDate($date);
        $totalVerified = $collections->sum('paid_amount');
        $cashTotal     = $collections->where('payment_method', 'cash')->sum('paid_amount');
        $onlineTotal   = $totalVerified - $cashTotal;

        ClosingBalance::create([
            'amount'        => $totalVerified,
            'cash_amount'   => $cashTotal,   // ← always explicitly saved
            'online_amount' => $onlineTotal,
            'date'          => $date,
            'status'        => $cashTotal > 0 ? 'pending' : 'deposited',
            'notes'         => $request->input('notes'),
        ]);

        $msg = 'Day closed. Total: ₹' . number_format($totalVerified, 2)
             . ' | Cash: ₹' . number_format($cashTotal, 2)
             . ' | Online: ₹' . number_format($onlineTotal, 2);
        if ($cashTotal > 0) {
            $msg .= ' | ⚠ ₹' . number_format($cashTotal, 2) . ' cash pending deposit.';
        }

        return redirect()->back()->with('success', $msg);
    }

    // ─────────────────────────────────────────────────────────────
    //  STORE DEPOSIT — FIFO across pending closings
    // ─────────────────────────────────────────────────────────────
    public function depositedHistorystore(Request $request)
    {
        $request->validate([
            'image'  => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bank'   => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'notes'  => 'nullable|string|max:500',
        ]);

        // Compute available per closing (not global sum)
        $pendingClosings = ClosingBalance::where('status', 'pending')->orderBy('date')->get();
        $cashAvailable   = 0;
        foreach ($pendingClosings as $pc) {
            $dep = DepositeAmount::where('closing_balance_id', $pc->id)->sum('amount');
            $cashAvailable += max(0, (float)$pc->cash_amount - (float)$dep);
        }

        if ((float)$request->amount > round($cashAvailable, 2)) {
            return redirect()->back()->with('error',
                'Deposit ₹' . number_format($request->amount, 2)
                . ' exceeds available cash ₹' . number_format($cashAvailable, 2) . '.'
            );
        }

        // Save image once, reuse filename across split records
        $imageName = '';
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/deposite-amount'), $imageName);
        }

        $remaining = (float)$request->amount;

        foreach ($pendingClosings as $closing) {
            if ($remaining <= 0) break;

            $alreadyDep = DepositeAmount::where('closing_balance_id', $closing->id)->sum('amount');
            $netOwed    = (float)$closing->cash_amount - (float)$alreadyDep;

            if ($netOwed <= 0) {
                $closing->update(['status' => 'deposited']);
                continue;
            }

            $allocate = min($remaining, $netOwed);

            DepositeAmount::create([
                'closing_balance_id' => $closing->id,
                'amount'             => $allocate,
                'bank_name'          => $request->bank,
                'image'              => $imageName,
                'date'               => now()->toDateString(),
                'status'             => 'deposited',
                'notes'              => $request->input('notes'),
            ]);

            $remaining -= $allocate;

            // Re-check if now fully deposited
            $totalDep = DepositeAmount::where('closing_balance_id', $closing->id)->sum('amount');
            if (round((float)$totalDep, 2) >= round((float)$closing->cash_amount, 2)) {
                $closing->update(['status' => 'deposited']);
            }
        }

        return redirect()->back()->with('success',
            '₹' . number_format($request->amount, 2)
            . ' deposited to ' . $request->bank . ' successfully.'
        );
    }

    // ─────────────────────────────────────────────────────────────
    //  DEPOSITED HISTORY
    // ─────────────────────────────────────────────────────────────
    public function depositedHistory()
    {
        $history = DepositeAmount::with('closingBalance')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('finance::dailycollection.deposited', compact('history'));
    }

    // ─────────────────────────────────────────────────────────────
    //  ALL COLLECTIONS
    // ─────────────────────────────────────────────────────────────
    public function AllCollection(Request $request)
    {
        $filter   = $request->input('filter', 'all');
        $month    = $request->input('month');
        $year     = $request->input('year');
        $dateFrom = $request->input('date_from');
        $dateTo   = $request->input('date_to');

        $allcollections = $this->getFilteredVerified($filter, $month, $year, $dateFrom, $dateTo);
        $total          = $allcollections->sum('amount');
        $cashTotal      = $allcollections->where('payment_method', 'cash')->sum('amount');
        $onlineTotal    = $total - $cashTotal;

        $openingBalance = 0;
        if ($filter === 'custom' && $dateFrom) {
            $pBefore = ClosingBalance::where('status', 'pending')
                ->whereDate('date', '<', $dateFrom)->get();
            foreach ($pBefore as $pc) {
                $dep = DepositeAmount::where('closing_balance_id', $pc->id)->sum('amount');
                $openingBalance += max(0, (float)$pc->cash_amount - (float)$dep);
            }
        }

        $years = range(Carbon::now()->year, 2020);

        return view('finance::dailycollection.allcollection', compact(
            'allcollections', 'total', 'cashTotal', 'onlineTotal',
            'filter', 'month', 'year', 'dateFrom', 'dateTo', 'years', 'openingBalance'
        ));
    }

    // ─────────────────────────────────────────────────────────────
    //  FILTERED VERIFIED
    // ─────────────────────────────────────────────────────────────
    private function getFilteredVerified(string $filter, ?string $month, ?string $year, ?string $dateFrom, ?string $dateTo)
    {
        $query = PaymentVerification::with([
            'customer', 'customerPayment',
            'customerTicketPayment', 'ticket', 'branch',
        ]);

        switch ($filter) {
            case 'month':
                $m = $month ?? Carbon::now()->month;
                $y = $year  ?? Carbon::now()->year;
                $query->whereMonth('payment_date', $m)->whereYear('payment_date', $y);
                break;
            case 'year':
                $query->whereYear('payment_date', $year ?? Carbon::now()->year);
                break;
            case 'custom':
                if ($dateFrom) $query->whereDate('payment_date', '>=', $dateFrom);
                if ($dateTo)   $query->whereDate('payment_date', '<=', $dateTo);
                break;
        }

        return $query->get()->map(function ($v) {
            $name = $v->customer_name;
            if ($v->type === 'Ticket') {
                $name = optional($v->ticket)->subject
                    ? 'Ticket #' . $v->ticket->id . ' — ' . $v->ticket->subject
                    : 'Ticket #' . ($v->ticket_id ?? 'N/A');
            }
            $reference = $v->type === 'Ticket'
                ? 'TKT-' . ($v->ticket_id ?? $v->id)
                : 'INST-' . ($v->customer_payment_id ?? $v->id);

            return (object)[
                'id'             => $v->id,
                'name'           => $name,
                'branch'         => optional($v->branch)->name ?? '—',
                'payment_method' => $v->payment_method,
                'payment_date'   => $v->payment_date,
                'paid_amount'    => $v->paid_amount,
                'amount'         => $v->paid_amount,
                'total_amount'   => $v->total_amount,
                'remaining'      => $v->remaining_amount,
                'message'        => $v->message ?? '—',
                'type'           => $v->type,
                'reference_no'   => $reference,
                'status'         => $v->status,
            ];
        })
        ->sortByDesc('payment_date')
        ->values();
    }
}