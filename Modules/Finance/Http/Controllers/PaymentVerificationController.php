<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Finance\Entities\Payment;
use Modules\Finance\Entities\PaymentVerification;
use Modules\Finance\Entities\PaymentVerified;
use Modules\Lead\Entities\CustomerPayment;

class PaymentVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PaymentVerification::with(['customer', 'lead', 'branch'])->get();
        return view('finance::paymentverification.index', compact('data'));
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
    //

    public function store(Request $request, $id)
    {
        // dd($id);

        $verification = PaymentVerification::findOrFail($id);
        // dd($verification->customer_name);
        // $customerId = $verification->customer_id;
        // $leadId = $verification->lead_id;
        // $branchId = $verification->branch_id;

        // // $name => $verification->customer->lead->name;
        // // Step 3: Insert into PaymentVerified table
        // PaymentVerified::create([
        //     'customer_id' => $customerId ?? $id,
        //     'lead_id' => $leadId ?? Null,
        //     'branch_id' => $branchId,
        //     'total_amount' => $request->total_amount,
        //     'paid_amount' => $request->paid_amount,
        //     'remaining_amount' => $request->remaining_amount,
        //     'date' => $request->date,
        //     'status' => 'verify',
        // ]);

        // Step 4: Insert into Payments table
        Payment::create([
            'name' => $verification->customer_name ?? 'Lead Payment',
            'amount' => $request->paid_amount,
            'payment_method' => $verification->payment_method ?? 'cash',
            'payment_date' => $request->date,
            'status' => 'verify',
            'message' => $request->message,
        ]);
        $verification->update(['status' => 'off']);
        return redirect()->back()->with('success', 'Payment verified successfully.');
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
