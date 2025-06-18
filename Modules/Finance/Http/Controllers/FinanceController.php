<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Lead\Entities\Customer;
use Modules\Lead\Entities\CustomerPayment;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $customers = Customer::all();
        return view('finance::payment.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
     {
        $request->validate([
            'customer_id' => 'required',
            'amount' => 'required|numeric|min:1',
            'payment_mode' => 'required',
            'date' => 'required|date',
        ]);

        $customer = Customer::findOrFail($request->customer_id);

        // 1. Store payment
        CustomerPayment::create([
            'customer_id' => $customer->id,
            'lead_id' => $customer->lead_id,
            'branch_id' => $customer->branch_id,
            'created_by' => Auth::id(),
            'paid_amount' => $request->amount,
            'payment_method' => $request->payment_mode,
            'status' => 'completed', // optional
            'created_at' => $request->date,
        ]);

        // 2. Update customer amount
        $new_paid = $customer->paid_amount + $request->amount;
        $new_due = max(0, $customer->total_amount - $new_paid);

        $customer->update([
            'paid_amount' => $new_paid,
            'due_amount' => $new_due,
        ]);

        return redirect()->back()->with('success', 'Payment added successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('finance::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('finance::edit');
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
