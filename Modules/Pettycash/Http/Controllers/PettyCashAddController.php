<?php

namespace Modules\Pettycash\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Branch\Entities\Branch;
use Illuminate\Support\Str;
use Modules\Pettycash\Entities\PettyCashAdd;

class PettyCashAddController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role->name === 'Super Admin') {
            $pettycash = PettyCashAdd::with('branch')->latest()->get();
        } else {
            $pettycash = PettyCashAdd::with('branch')
                ->where('branch_id', $user->branch_id)
                ->latest()
                ->get();
        }

        $branches = Branch::where('status', 'on')->get();

        return view('pettycash::cash_add.index', compact('branches', 'pettycash'));
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
        // Calculate total_amount as numeric
        $total_amount = (float)$request->amount + (float)$request->lm_remaining_cash;
        // dd($total_amount);

        $slug = Str::slug($request->title);

        PettyCashAdd::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'month' => $request->month,
            'lm_remaining_cash' => $request->lm_remaining_cash, //last month remaining cash
            'total_amount' => $total_amount,
            'remaining_cash' => $total_amount,
            'slug' => $slug,
            'branch_id' => $request->branch_id,
            'created_by' => auth()->user()->id,
            'status' => $request->status
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
        $new_total_amount = (float)$request->amount + (float)$request->lm_remaining_cash;

        // Calculate the difference
        $difference = $new_total_amount - (float)$pettycash->total_amount;

        // Update remaining cash based on the difference
        $new_remaining_cash = (float)$pettycash->remaining_cash + $difference;

        $slug = Str::slug($request->title);

        $pettycash->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'month' => $request->month,
            'lm_remaining_cash' => $request->lm_remaining_cash,
            'total_amount' => $new_total_amount,
            'remaining_cash' => $new_remaining_cash,
            'slug' => $slug,
            'branch_id' => $request->branch_id,
            'created_by' => auth()->user()->id,
            'status' => $request->status
        ]);

        return back()->with('success', 'Petty cash updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pettycash = PettyCashAdd::findOrfail($id);
        $pettycash->delete();
        return redirect()->back()->with('success', 'Petty Cash Deleted!');
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
            'status' => $status
        ]);
        return redirect()->back()->with('success', 'Petty Cash Updated!');
    }
}
