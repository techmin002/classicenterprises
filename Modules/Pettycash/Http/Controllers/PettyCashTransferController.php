<?php

namespace Modules\Pettycash\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pettycash\Entities\PettyCashAdd;
use Modules\Pettycash\Entities\PettyCashRequest;
use Modules\Pettycash\Entities\PettyCashTransaction;
use Modules\Pettycash\Entities\PettyCashTransfer;

class PettyCashTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $transfer = PettyCashTransfer::with('branch');

        // ✅ Branch filter
        if ($user->role->name === 'Super Admin') {
            if (session('branch_id')) {
                $transfer->where('branch_id', session('branch_id'));
            }
        } else {
            $transfer->where('branch_id', $user->branch_id);
        }

        // ✅ Predefined filters
        if ($request->filter == '7days') {
            $transfer->where('created_at', '>=', now()->subDays(7));
        }
        if ($request->filter == '15days') {
            $transfer->where('created_at', '>=', now()->subDays(15));
        }
        if ($request->filter == '1month') {
            $transfer->where('created_at', '>=', now()->subMonth());
        }

        // ✅ Custom date filter
        if ($request->filled(['start_date', 'end_date'])) {
            $start = $request->start_date . ' 00:00:00';
            $end = $request->end_date . ' 23:59:59';
            $transfer->whereBetween('created_at', [$start, $end]);
        }

        $transfer = $transfer->latest()->get();

        return view('pettycash::cash_transfer.index', compact('transfer'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pettycash::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id): RedirectResponse
    {
        // dd($request->all());

        $validated = $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'transfer_method' => 'required|in:cash,cheque,online',
            'cheque_number'   => 'nullable|required_if:transfer_method,cheque|string|max:50',
            'receipt'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('petty_cash_receipts', 'public');
        }
        // 1. Create a transfer record
        PettyCashTransfer::create([
            'branch_id' => session('branch_id'),
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'description' => $validated['description'] ?? null,
            'transfer_method' => $validated['transfer_method'],
            'cheque_number'   => $validated['transfer_method'] === 'cheque' ? $validated['cheque_number'] : null,
            'receipt'         => $receiptPath,
        ]);

        // 2. Update PettyCashRequest as approved
        $cashRequest = PettyCashRequest::findOrFail($id);
        $cashRequest->status = 'approved';
        $cashRequest->transfer_by = auth()->user()->id;
        $cashRequest->amount = $validated['amount'];
        $cashRequest->save();
        // 3. Extract month & year from the display date field (provided as hidden)
        $monthCompareDate = $request->month_compare_date ?? $validated['date'];
        $dateObj = \Carbon\Carbon::parse($monthCompareDate);
        $month = $dateObj->format('m');
        $year = $dateObj->format('Y');

        // 4. Update PettyCashAdd for that branch + month/year
        $pettyCash = PettyCashAdd::where('branch_id', session('branch_id'))
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->first();


        if ($pettyCash) {
            $pettyCash->total_amount += $validated['amount'];
            $pettyCash->remaining_cash += $validated['amount'];
            $pettyCash->transfer_by = auth()->user()->id;
            $pettyCash->requested_by = $cashRequest['requested_by'];
            $pettyCash->save();
        } else {
            // If entry not exists, create a new one with provided date
            PettyCashAdd::create([
                'title' => 'Petty Cash Requested',
                'slug' => 'Petty-Cash-Requested',
                'branch_id' => session('branch_id'),
                'date' => $monthCompareDate,
                'total_amount' => $validated['amount'],
                'remaining_cash' => $validated['amount'],
            ]);
        }

        $latestTransaction = PettyCashTransaction::where('branch_id', session('branch_id'))
            ->latest('id')
            ->first();

        if ($latestTransaction) {
            // Update remaining cash after this transaction
            $latestTransaction->remaining_cash_after += $validated['amount'];
            $latestTransaction->save();
        }

        return redirect()->route('pettycash-transfer.index')->with('success', 'Transfer successful and petty cash updated.');
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('pettycash::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('pettycash::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
