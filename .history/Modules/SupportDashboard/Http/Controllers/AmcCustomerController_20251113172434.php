<?php

namespace Modules\SupportDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AmcCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('supportdashboard::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supportdashboard::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branch_id = session('branch_id');
        } else {
            $branch_id = auth()->user()->branch_id;
        }
        
        $ticket = CustomerTicket::create([
            'customer_id'     => $request->customer_id,
            'branch_id'       => $branch_id,
            'type'            => $request->type,
            'support_type'    => $request->support_type,
            'priority'        => $request->priority,
            'amc'             => $request->amc,
            'warranty'        => $request->warranty,
            'assign_to'       => $request->assign_to,
            'service_charge'  => $request->service_charge,

            'amount'        => $request->amount,

            // 🧾 Payment Section
            'payment_status'    => $request->payment_status,
            'payment_method'    => $request->payment_method,

            // 💰 Cash Payment
            'cash_amount'       => $request->cash_amount ?? 0,
            'cash_receipt'      => $cashFileName,

            // 💳 Online Payment
            'online_amount'     => $request->online_amount ?? 0,
            'online_receipt'    => $onlineFileName,

            // 🧾 Cheque Payment
            'cheque_amount'     => $request->cheque_amount ?? 0,
            'cheque_number'     => $request->cheque_number,
            'cheque_receipt'    => $chequeFileName,

            'message'        => $request->message,
            'status'          => 'queue',
        ]);

        if ($request->customer_id) {
            $customer = Customer::findOrFail($request->customer_id);
            $customer->ticket_status = 'queue';
            $customer->save();
        }

        TicketNote::create([
            'ticket_id' => $ticket->id,
            'note' => $request->message,
        ]);

        Log::create([
            'perform'   => auth()->user()->name
                . ' Task ' . $request->support_type . ' Created:'
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        return redirect()->route('registercustomer-ticket.queue')->with('success', 'Register Customer Ticket Created Successfully.');
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('supportdashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('supportdashboard::edit');
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
