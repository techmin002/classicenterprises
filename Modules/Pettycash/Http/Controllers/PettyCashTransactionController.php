<?php

namespace Modules\Pettycash\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Branch\Entities\Branch;
use Modules\PetrolMGNT\Entities\Petrol;
use Modules\Pettycash\Entities\PettyCashTransaction;

class PettyCashTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $transactions = PettyCashTransaction::query()->with('category');
        // Branch filter
        if ($user->role->name !== 'Super Admin') {
            $transactions->where('branch_id', $user->branch_id);
            $branch_id = $user->branch_id;
        } elseif (session('branch_id')) {
            $transactions->where('branch_id', session('branch_id'));
            $branch_id = session('branch_id');
        }
                $branch = Branch::select('name')->where('id',$branch_id)->first();
        // Predefined filters
        if ($request->filter == '7days') {
            $transactions->where('created_at', '>=', now()->subDays(7));
        }

        if ($request->filter == '15days') {
            $transactions->where('created_at', '>=', now()->subDays(15));
        }

        if ($request->filter == '1month') {
            $transactions->where('created_at', '>=', now()->subMonth());
        }

        // Custom date filter
        if ($request->filled(['start_date', 'end_date'])) {
            $start = $request->start_date . ' 00:00:00';
            $end = $request->end_date . ' 23:59:59';
            $transactions->whereBetween('created_at', [$start, $end]);
        }

        // Debug check
        // dd($request->all(), $transactions->toSql(), $transactions->getBindings());

        $transactions = $transactions->latest()->get();
        return view('pettycash::cash_transaction.index', compact('transactions','branch'));
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
    public function store(Request $request) {}

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
