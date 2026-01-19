<?php

namespace Modules\Pettycash\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Branch\Entities\Branch;
use Modules\Pettycash\Entities\PettyCashAdd;
use Modules\Pettycash\Entities\PettyCashTransaction;

class PettyCashAddController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branchId = session('branch_id');
        } else {
            $branchId = auth()->user()->branch_id;
        }
        $user = auth()->user();

        // dd($branchId);

        $pettycash = PettyCashAdd::with('branch');

        // ✅ Branch filter
        if ($user->role->name === 'Super Admin') {
            if (session('branch_id')) {
                $pettycash->where('branch_id', session('branch_id'));
            }
        } else {
            $pettycash->where('branch_id', $user->branch_id);
        }

        // ✅ Predefined filters
        if ($request->filter == '7days') {
            $pettycash->where('created_at', '>=', now()->subDays(7));
        }
        if ($request->filter == '15days') {
            $pettycash->where('created_at', '>=', now()->subDays(15));
        }
        if ($request->filter == '1month') {
            $pettycash->where('created_at', '>=', now()->subMonth());
        }

        // ✅ Custom date filter
        if ($request->filled(['start_date', 'end_date'])) {
            $start = $request->start_date.' 00:00:00';
            $end = $request->end_date.' 23:59:59';
            $pettycash->whereBetween('created_at', [$start, $end]);
        }

        $pettycash = $pettycash->latest()->get();

        // ✅ Last record total
        $last = PettyCashAdd::where('branch_id', $branchId)->latest()->first();

        $lasttotal = $last ? $last['remaining_cash'] : 0;
        // dd($lasttotal);
        $branches = Branch::where('status', 'on')->get();

        $currentMonth = now()->month;
        $currentYear = now()->year;

        if ($branchId) {
            $exists = PettyCashAdd::where('branch_id', $branchId)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();

            if (! $exists) {

                $last = PettyCashAdd::where('branch_id', $branchId)
                    ->latest()
                    ->first();

                $remaining = $last ? $last->remaining_cash : 0;

                // ✅ Create new month petty cash
                $new = PettyCashAdd::create([
                    'title' => 'Auto Carry Forward '.now()->format('F Y'),
                    'amount' => 0,
                    'date' => now()->startOfMonth(),
                    'lm_remaining_cash' => $remaining,
                    'total_amount' => $remaining,
                    'slug' => 'petty_cash_forward',
                    'remaining_cash' => $remaining,
                    'branch_id' => $branchId,
                    'created_by' => auth()->id(),
                    'status' => 'on',
                ]);

                // ✅ IMPORTANT: Last month remaining = 0
                if ($last) {
                    $last->update([
                        'remaining_cash' => 0,
                    ]);
                }
            }
        }

        return view('pettycash::cash_add.index', compact('branches', 'pettycash', 'lasttotal'));
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
    public function store(Request $request)
    {
        // dd($request->all());
        $branchId = session('branch_id') ?? auth()->user()->branch_id;

        $date = Carbon::parse($request->date);
        $exists = PettyCashAdd::where('branch_id', $branchId)
            ->whereMonth('date', $date->month)
            ->whereYear('date', $date->year)
            ->first();

        // $remaining_amount = $exists->remaining_cash;

        if ($exists) {
            $exists->amount = $request->amount;
            $exists->date = $request->date;
            $exists->total_amount = $exists->total_amount + $request->amount;
            $exists->amount = $request->amount;
            $exists->remaining_cash = $exists->remaining_cash + $request->amount;

            $exists->save();
        } else {

            $latestRecord = PettyCashAdd::where('branch_id', $branchId)
                ->latest()
                ->first();

            // Step 2: If found, set its remaining_cash to 0
            if ($latestRecord) {
                $latestRecord->update(['remaining_cash' => 0]);
            }

            $total_amount = (float) $request->amount + (float) $request->lm_remaining_cash;

            $slug = Str::slug($request->title);

            PettyCashAdd::create([
                'title' => $request->title,
                'amount' => $request->amount,
                'date' => $request->date,
                // 'month' => $request->month,
                'lm_remaining_cash' => $request->lm_remaining_cash,
                'total_amount' => $total_amount,
                'remaining_cash' => $total_amount,
                'slug' => $slug,
                'branch_id' => session('branch_id'),
                'created_by' => auth()->user()->id,
                'status' => $request->status,
            ]);
        }

        // $latestRecord = PettyCashAdd::where('branch_id', $branchId)
        //     ->latest()
        //     ->first();

        // // Step 2: If found, set its remaining_cash to 0
        // if ($latestRecord) {
        //     $latestRecord->update(['remaining_cash' => 0]);
        // }

        // $total_amount = (float) $request->amount + (float) $request->lm_remaining_cash;

        // $slug = Str::slug($request->title);
        // PettyCashAdd::create([
        //     'title' => $request->title,
        //     'amount' => $request->amount,
        //     'date' => $request->date,
        //     // 'month' => $request->month,
        //     'lm_remaining_cash' => $request->lm_remaining_cash,
        //     'total_amount' => $total_amount,
        //     'remaining_cash' => $total_amount,
        //     'slug' => $slug,
        //     'branch_id' => session('branch_id'),
        //     'created_by' => auth()->user()->id,
        //     'status' => $request->status,
        // ]);

        $latestTransaction = PettyCashTransaction::where('branch_id', session('branch_id'))
            ->latest('id')
            ->first();

        if ($latestTransaction) {
            // Update remaining cash after this transaction
            $latestTransaction->remaining_cash_after += $request->amount;
            $latestTransaction->save();
        }
        Log::create([
            'perform' => auth()->user()->name.' Added Petty cash '.now(),
            'user_id' => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url' => url()->current(),
        ]);

        return back()->with('success', 'Petty cash Added Successfully');
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
        $pettycash = PettyCashAdd::findOrFail($id);

        // Calculate the new total amount
        $new_total_amount = (float) $request->amount + (float) $request->lm_remaining_cash;

        // Calculate the difference
        $difference = $new_total_amount - (float) $pettycash->total_amount;

        // Update remaining cash based on the difference
        $new_remaining_cash = (float) $pettycash->remaining_cash + $difference;

        $slug = Str::slug($request->title);

        $pettycash->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            // 'month' => $request->month,
            'year' => $request->year,
            'lm_remaining_cash' => $request->lm_remaining_cash,
            'total_amount' => $new_total_amount,
            'remaining_cash' => $new_remaining_cash,
            'slug' => $slug,
            'branch_id' => session('branch_id'),
            'created_by' => auth()->user()->id,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Petty cash updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $branchId = session('branch_id') ?? auth()->user()->branch_id;

        $deleted = PettyCashAdd::where('branch_id', $branchId)->findOrFail($id);

        // Step 1: Find next recent record for remaining cash restoration
        $previousRecord = PettyCashAdd::where('branch_id', $branchId)
            ->where('id', '<', $deleted->id)
            ->latest('id')
            ->first();

        if ($previousRecord) {
            // dd($previousRecord->title);
            // Restore its remaining cash amount
            $previousRecord->update([
                'remaining_cash' => $deleted->lm_remaining_cash,
            ]);
        }

        // Step 2: Fix petty cash transaction remaining cash
        $transaction = PettyCashTransaction::where('branch_id', $branchId)
            ->latest('id')
            ->first();

        if ($transaction) {
            $transaction->remaining_cash_after = $deleted->lm_remaining_cash;
            $transaction->save();
        }

        // Step 3: Delete the petty cash record
        $deleted->delete();

        return redirect()->back()->with('success', 'Petty Cash Deleted! Data Restored Properly ✅');
    }

    public function Status($id)
    {
        $pettycash = PettyCashAdd::findOrfail($id);
        if ($pettycash->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $pettycash->update([
            'status' => $status,
        ]);

        return redirect()->back()->with('success', 'Petty Cash Updated!');
    }
}
