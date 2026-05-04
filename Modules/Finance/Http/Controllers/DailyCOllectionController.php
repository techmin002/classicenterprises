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
    //  INDEX — Today's verified collections
    // ─────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $date = $request->input('date') ?? Carbon::today()->toDateString();

        $alreadyClosed = ClosingBalance::whereDate('date', Carbon::today())->exists();

        $collections = $this->getVerifiedByDate($date);

        $grandTotal  = $collections->sum('paid_amount');
        $cashTotal   = $collections->where('payment_method', 'cash')->sum('paid_amount');
        $onlineTotal = $grandTotal - $cashTotal;

        // Pending = day closed but cash not yet deposited
        $balance = ClosingBalance::where('status', 'pending')
            ->whereDate('date', Carbon::today()->toDateString())
            ->first();

        return view('finance::dailycollection.index', compact(
            'collections', 'grandTotal', 'cashTotal', 'onlineTotal',
            'date', 'alreadyClosed', 'balance'
        ));
    }

    // ─────────────────────────────────────────────────────────────
    //  CORE QUERY
    //  Source of truth = payment_verifications
    //  • payment_date  → when verified (used as the date axis)
    //  • payment_method, paid_amount, message → all on this table
    //  • type accessor → 'Ticket' if ticket_id set, else 'Installation'
    //  We eager-load customer + ticket only for display names.
    // ─────────────────────────────────────────────────────────────
    private function getVerifiedByDate(?string $date)
    {
        $query = PaymentVerification::with([
            'customer',
            'customerPayment',
            'customerTicketPayment',
            'ticket',
            'branch',
        ]);

        if ($date) {
            $query->whereDate('payment_date', $date);
        }

        return $query->get()->map(function ($v) {
            // Display name: prefer customer name, fallback to lead name
            $name = $v->customer_name; // uses existing getCustomerNameAttribute()

            // Override name for ticket type
            if ($v->type === 'Ticket') {
                $name = optional($v->ticket)->subject
                    ? 'Ticket #' . $v->ticket->id . ' — ' . $v->ticket->subject
                    : 'Ticket #' . ($v->ticket_id ?? 'N/A');
            }

            // Reference number
            $reference = $v->type === 'Ticket'
                ? 'TKT-' . ($v->ticket_id ?? $v->id)
                : 'INST-' . ($v->customer_payment_id ?? $v->id);

            return (object)[
                'id'             => $v->id,
                'name'           => $name,
                'branch'         => optional($v->branch)->name ?? '—',
                'payment_method' => $v->payment_method,         // raw lowercase from DB
                'payment_date'   => $v->payment_date,
                'amount'         => $v->paid_amount,
                'total_amount'   => $v->total_amount,
                'remaining'      => $v->remaining_amount,
                'message'        => $v->message ?? '—',
                'type'           => $v->type,                   // uses getTypeAttribute()
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

        if (ClosingBalance::where('date', $date)->exists()) {
            return redirect()->back()->with('error', 'Closing amount already stored for today.');
        }

        $collections   = $this->getVerifiedByDate($date);
        $totalVerified = $collections->sum('amount');
        $cashTotal     = $collections->where('payment_method', 'cash')->sum('amount');

        ClosingBalance::create([
            'amount'      => $totalVerified,
            'cash_amount' => $cashTotal,
            'date'        => $date,
            'status'      => 'pending',
        ]);

        return redirect()->back()->with('success',
            'Day closed. Total: ₹' . number_format($totalVerified, 2) .
            '  |  Cash: ₹' . number_format($cashTotal, 2) .
            '  |  Online: ₹' . number_format($totalVerified - $cashTotal, 2)
        );
    }

    // ─────────────────────────────────────────────────────────────
    //  STORE DEPOSIT — only cash can be deposited
    // ─────────────────────────────────────────────────────────────
    public function depositedHistorystore(Request $request)
    {
        $request->validate([
            'image'  => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bank'   => 'required|string',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $closing = ClosingBalance::whereDate('date', today())
            ->where('status', 'pending')
            ->first();

        if (!$closing) {
            return redirect()->back()->with('error',
                'No pending closing balance for today. Please close the day first.'
            );
        }

        $cashAvailable = (float) ($closing->cash_amount ?? 0);

        if ((float) $request->amount > $cashAvailable) {
            return redirect()->back()->with('error',
                "Deposit ₹{$request->amount} exceeds available cash ₹{$cashAvailable}. " .
                "Online payments are already credited to the bank automatically."
            );
        }

        $imageName = '';
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/deposite-amount'), $imageName);
        }

        DepositeAmount::create([
            'amount'    => $request->amount,
            'bank_name' => $request->bank,
            'image'     => $imageName,
            'date'      => now(),
            'status'    => 'deposited',
        ]);

        $closing->update(['status' => 'deposited']);

        return redirect()->back()->with('success',
            '₹' . number_format($request->amount, 2) . ' deposited to ' . $request->bank . ' successfully.'
        );
    }

    // ─────────────────────────────────────────────────────────────
    //  DEPOSITED HISTORY
    // ─────────────────────────────────────────────────────────────
    public function depositedHistory()
    {
        $history = DepositeAmount::orderBy('date', 'desc')->get();
        return view('finance::dailycollection.deposited', compact('history'));
    }

    // ─────────────────────────────────────────────────────────────
    //  ALL COLLECTIONS — filterable report
    // ─────────────────────────────────────────────────────────────
    public function AllCollection(Request $request)
    {
        $filter   = $request->input('filter', 'all'); // all | month | year | custom
        $month    = $request->input('month');
        $year     = $request->input('year');
        $dateFrom = $request->input('date_from');
        $dateTo   = $request->input('date_to');

        $allcollections = $this->getFilteredVerified($filter, $month, $year, $dateFrom, $dateTo);

        $total       = $allcollections->sum('amount');
        $cashTotal   = $allcollections->where('payment_method', 'cash')->sum('amount');
        $onlineTotal = $total - $cashTotal;

        $years = range(Carbon::now()->year, 2020);

        return view('finance::dailycollection.allcollection', compact(
            'allcollections', 'total', 'cashTotal', 'onlineTotal',
            'filter', 'month', 'year', 'dateFrom', 'dateTo', 'years'
        ));
    }

    // ─────────────────────────────────────────────────────────────
    //  FILTERED VERIFIED — same map as getVerifiedByDate
    //  but with month/year/custom range on payment_date
    // ─────────────────────────────────────────────────────────────
    private function getFilteredVerified(
        string $filter,
        ?string $month,
        ?string $year,
        ?string $dateFrom,
        ?string $dateTo
    ) {
        $query = PaymentVerification::with([
            'customer',
            'customerPayment',
            'customerTicketPayment',
            'ticket',
            'branch',
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
            // 'all' — no filter
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