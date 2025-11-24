<?php

namespace Modules\SupportDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Inventory\Entities\Customer;
use Modules\SupportDashboard\Entities\CustomerTicket;
use Modules\SupportDashboard\Entities\TicketNote;

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
            'support_type'    => $request->support_type,
            'priority'        => $request->priority,
            'amc'             => $request->amc,
            'warranty'        => $request->warranty,
            'type'     => $request->type,
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

        return redirect()->route('amccustomer-ticket.queue')->with('success', 'Amc Customer Ticket Created Successfully.');
    }

    public function queue()
    {
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branch_id = session('branch_id');
        } else {
            $branch_id = auth()->user()->branch_id;
        }
        $users = User::where('branch_id', $branch_id)->get();
        $customers = CustomerTicket::with(['amc', 'customer'])->where('branch_id', $branch_id)->where('type', 'amc')->where('status', 'queue')->latest()->get();


        return view('supportdashboard::amc_customer.queue', compact('customers', 'users'));
    }

    public function messageupdate(Request $request, $id)
    {
        // dd('MESSAGE UPDATE');
        $ticket = CustomerTicket::findOrFail($id);

        $ticket->message = $request->note;
        $ticket->save();

        TicketNote::create([
            'ticket_id' => $ticket->id,
            'note' => $request->note,
        ]);
        // Log::create([
        //     'perform'   => auth()->user()->name . ' Message Update : '
        //         . $user->name . ' at ' . now(),
        //     'user_id'   => auth()->user()->id,
        //     'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
        //     'url'       => url()->current(),
        // ]);
        return back()->with('success', 'Message Update successfully.');
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
