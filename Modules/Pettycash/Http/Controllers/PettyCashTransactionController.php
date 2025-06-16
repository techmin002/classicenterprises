<?php

namespace Modules\Pettycash\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\PetrolMGNT\Entities\Petrol;
use Modules\Pettycash\Entities\PettyCashTransaction;

class PettyCashTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Admin: see all transactions
        if ($user->role->name === 'Super Admin') {
            $transactions = PettyCashTransaction::latest()->get();
        } else {
            // Non-admin: see only branch transactions
            $branchId = $user->branch_id;
            $transactions = PettyCashTransaction::where('branch_id', $branchId)
                ->latest()
                ->get();
        }
        $bikename = Petrol::with('bike')->get();
        return view('pettycash::cash_transaction.index', compact('transactions', 'bikename'));
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
