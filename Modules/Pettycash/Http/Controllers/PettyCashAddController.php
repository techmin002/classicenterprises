<?php

namespace Modules\Pettycash\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Branch\Entities\Branch;
use Modules\Pettycash\Entities\PettyCash;
use Illuminate\Support\Str;

class PettyCashAddController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pettycash = PettyCash::with('branch')->get();
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
        // dd($request->all());
        $slug = Str::slug($request->title);
        PettyCash::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'month' => $request->month,
            'remaining_cash' => $request->remaining_cash,
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
        // dd($request->all());
        $pettycash = PettyCash::findOrfail($id);
        $slug = Str::slug($request->title);
        $pettycash->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'month' => $request->month,
            'remaining_cash' => $request->remaining_cash,
            'slug' => $slug,
            'branch_id' => $request->branch_id,
            'status' => $request->status
        ]);
        return back()->with('success', 'Petty cash Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pettycash = PettyCash::findOrfail($id);
        $pettycash->delete();
        return redirect()->back()->with('success', 'Petty Cash Deleted!');
    }

    public function Status($id)
    {
        $pettycash = PettyCash::findOrfail($id);
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
