<?php

namespace Modules\Pettycash\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pettycash\Entities\PettyCashAdd;
use Modules\Pettycash\Entities\PettyCashRequest;
use Modules\Pettycash\Entities\PettyCashTransfer;

class PettyCashTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Super Admin can see all transfers
        if ($user->role->name === 'Super Admin') {
            $transfer = PettyCashTransfer::with('branch')->latest()->get();
        } else {
            // Normal users see only their branch transfers
            $transfer = PettyCashTransfer::with('branch')
                ->where('branch_id', $user->branch_id)
                ->latest()
                ->get();
        }

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
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'branch_id' => 'required',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        // 1. Create a transfer record
        PettyCashTransfer::create([
            'branch_id' => $validated['branch_id'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'description' => $validated['description'] ?? null,
        ]);

        // 2. Update PettyCashRequest as approved
        $cashRequest = PettyCashRequest::findOrFail($id);
        $cashRequest->status = 'approved';
        $cashRequest->save();

        // 3. Add amount to petty cash of that branch for that month
        $month = $cashRequest->month;

        $pettyCash = PettyCashAdd::firstOrCreate(
            ['branch_id' => $validated['branch_id'], 'month' => $month],
            ['total_amount' => 0, 'remaining_cash' => 0]
        );

        $pettyCash->total_amount += $validated['amount'];
        $pettyCash->remaining_cash += $validated['amount'];
        $pettyCash->save();

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
