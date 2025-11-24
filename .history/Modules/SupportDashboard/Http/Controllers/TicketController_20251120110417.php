<?php

namespace Modules\SupportDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\AMC\Entities\AMC;
use Modules\AMC\Entities\AmcCustomer;
use Modules\AMC\Entities\OutsiderCustomerAMC;
use Modules\AMC\Entities\RegisterCustomerAMC;
use Modules\Lead\Entities\Customer;
use Modules\SupportDashboard\Entities\CustomerTicket;
use Modules\SupportDashboard\Entities\RegisterCustomerTicket;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branch_id = session('branch_id');
        } else {
            $branch_id = auth()->user()->branch_id;
        }
        $register = Customer::with(['lead', 'registerAmc'])
            ->where('branch_id', $branch_id)
            ->where(function ($query) {
                $query->where('ticket_status', 'report')
                    ->orWhere('ticket_status', 'complete')
                    ->orWhereNull('ticket_status');
            })
            ->get();

        // $outsider = CustomerTicket::with('amc')->where('branch_id', $branch_id)->where('type', 'outsider')->whereIn('status', ['complete', 'report', 'create'])->latest()->get();
        // $amccustomer = AmcCustomer::with(['customer', 'amc'])->where('branch_id', $branch_id)->whereIn('status', ['complete', 'report', 'create', ''])->latest()->get();

        $outsider = CustomerTicket::with('amc')
            ->where('branch_id', $branch_id)
            ->where('type', 'outsider')
            ->where(function ($query) {
                $query->whereIn('status', ['complete', 'report', 'create'])
                    ->orWhereNull('status');
            })
            ->latest()
            ->get();

        $amccustomer = AmcCustomer::with(['customer', 'amc'])
            ->where('branch_id', $branch_id)
            ->where(function ($query) {
                $query->whereIn('status', ['complete', 'report', 'create'])
                    ->orWhereNull('status');
            })
            ->latest()
            ->get();

        return view('supportdashboard::ticket.index', compact('register', 'outsider', 'amccustomer'));
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
    // public function store(Request $request)
    // {
    //     dd('Ticket Controller');
    //     dd($request->all());
    //     CustomerTicket::create([
    //         'customer_id'     => $request->customer_id,
    //         'support_type'    => $request->support_type,
    //         'priority'        => $request->priority,
    //         'amc'             => $request->amc ?? null,
    //         'warranty'        => $request->warranty ?? null,
    //         'assign_to'       => $request->assign_to ?? null,
    //         'payment_method'  => $request->payment_method ?? null,
    //         'service_charge'  => 0,
    //         'amount'          => 0,
    //         'paid_amount'     => 0,
    //         'message'         => $request->message ?? '',
    //         'status'          => 'queue',
    //         'created_by'      => auth()->user()->id ?? null,
    //     ]);

    //     $customer = Customer::findOrFail($request->customer_id);
    //     $customer->ticket_status = 'queue';
    //     $customer->save();

    //     Log::create([
    //         'perform'   => auth()->user()->name
    //             . ' Task ' . $request->support_type . ' Created:'
    //             . ' at ' . now(),
    //         'user_id'   => auth()->user()->id,
    //         'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
    //         'url'       => url()->current(),
    //     ]);

    //     return redirect()->route('supportdashboard-task.queue')->with('success', 'Support Ticket Created Successfully.');
    // }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('supportdashboard::show');
    }

    // public function queue()
    // {

    //     if (auth()->user()->role['name'] === 'Super Admin') {
    //         $branch_id = session('branch_id');
    //     } else {
    //         $branch_id = auth()->user()->branch_id;
    //     }
    //     $customers = Customer::with(['lead', 'registerAmc'])
    //         ->where('branch_id', $branch_id)
    //         ->where('ticket_status', 'queue')->get();

    //     $register = RegisterCustomerAMC::with(['customer', 'amc'])->where('branch_id', $branch_id)->latest()->get();
    //     $outsider = OutsiderCustomerAMC::with('amc')->where('branch_id', $branch_id)->latest()->get();

    //     $amcregister = RegisterCustomerAMC::with(['customer', 'amc'])->where('branch_id', $branch_id)->latest()->get();
    //     $amcoutsider = OutsiderCustomerAMC::with('amc')->where('branch_id', $branch_id)->latest()->get();
    //     return view('supportdashboard::queue.index', compact('customers', 'register', 'outsider', 'amcregister', 'amcoutsider'));
    // }


    // public function assign()
    // {
    //     if (auth()->user()->role->name === 'Super Admin') {
    //         $branchId = session('branch_id');
    //     } else {
    //         $branchId = auth()->user()->branch_id;
    //     }

    //     $data = Task::with('customer.lead', 'customer.products')->where('status', 'assign')->whereHas('customer', function ($query) use ($branchId) {
    //         $query->where('branch_id', $branchId);
    //     })
    //         ->get();
    //     $accessories = Accessory::all();

    //     $amcMap = [];

    //     // Group all accessories assigned via AMC by customer
    //     $assignAccessories = AmcAssignAccessory::with('accessory')->get();

    //     foreach ($assignAccessories as $item) {
    //         $customerId = $item->customer_id;
    //         $accessoryName = $item->accessory->name ?? null;

    //         if (!$accessoryName) continue;

    //         $assignedQty = $item->quantity ?? 0;

    //         // calculate already used quantity (from same table if you store used qty separately or in another table)
    //         $usedQty = $item->used_quantity ?? 0; // ❗ if no such column, change accordingly

    //         $remainingQty = max(0, $assignedQty - $usedQty);

    //         // map result
    //         if (!isset($amcMap[$customerId])) {
    //             $amcMap[$customerId] = [];
    //         }

    //         // if same accessory assigned multiple times to same customer, add
    //         if (isset($amcMap[$customerId][$accessoryName])) {
    //             $amcMap[$customerId][$accessoryName] += $remainingQty;
    //         } else {
    //             $amcMap[$customerId][$accessoryName] = $remainingQty;
    //         }
    //     }


    //     return view('supportdashboard::assign.index', compact('data', 'accessories', 'amcMap'));
    // }


    // public function complete()
    // {
    //     if (auth()->user()->role->name === 'Super Admin') {
    //         $branchId = session('branch_id');
    //     } else {
    //         $branchId = auth()->user()->branch_id;
    //     }

    //     $data = Task::with('customer.lead', 'customer.products', 'serviceItems') // include serviceItems
    //         ->where('status', 'complete')->whereHas('customer', function ($query) use ($branchId) {
    //             $query->where('branch_id', $branchId);
    //         })
    //         ->get();

    //     return view('supportdashboard::complete.index', compact('data'));
    // }
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

    public function customerDetails($id)
    {
        // dd($id);
        $customer = CustomerTicket::with([
            'customer',
            'payments',
            'accessories.accessory'
        ])->where('id', $id)->firstOrFail();

        return view('supportdashboard::amc_customer.details', compact('customer'));
    }
}
