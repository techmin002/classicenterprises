<?php

namespace Modules\SupportDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\AMC\Entities\AmcCustomer;
use Modules\Inventory\Entities\Customer;
use Modules\Lead\Entities\CustomerAccessory;
use Modules\SupportDashboard\Entities\CustomerTicket;
use Modules\SupportDashboard\Entities\CustomerTicketAccessory;
use Modules\SupportDashboard\Entities\CustomerTicketPayment;
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


    public function inservice()
    {
        // Branch selection
        $branch_id = auth()->user()->role['name'] === 'Super Admin'
            ? session('branch_id')
            : auth()->user()->branch_id;

        // Fetch AMC customers
        $amcCustomers = AmcCustomer::with(['customer', 'amc'])
            ->where('branch_id', $branch_id)
            ->where(function ($query) {
                $query->whereIn('status', ['on', 'report', 'complete'])
                    ->orWhereNull('status');
            })
            ->get();


        $finalData = [];

        foreach ($amcCustomers as $item) {

            if (!$item->amc) continue;

            // AMC total months (ONLY year exists now)
            $totalMonths = $item->amc->year * 12;

            // AMC beginning and end date
            $startDate = \Carbon\Carbon::parse($item->date);
            $amcEndDate = $startDate->copy()->addMonths($totalMonths);

            if (now()->gt($amcEndDate)) {
                continue; // DO NOT SHOW EXPIRED AMC
            }

            // Next service = last date + 4 months
            $nextServiceDate = \Carbon\Carbon::parse($item->last_date)->addMonths(4);

            // Show 2 days before the next service date
            $showFrom = $nextServiceDate->copy()->subDays(2);

            // Final condition
            if (
                $nextServiceDate->toDateString() <= $amcEndDate->toDateString() &&
                now()->toDateString() >= $showFrom->toDateString()
            ) {
                // Append calculated values
                $item->next_service_date = $nextServiceDate->toDateString();
                $item->amc_end_date = $amcEndDate->toDateString();
                $item->duration_months = $totalMonths / 12;

                $finalData[] = $item;
            }
        }

        return view('supportdashboard::amc_customer.inservice', [
            'amccustomer' => $finalData
        ]);
    }

    public function outservice()
    {
        // Branch selection
        $branch_id = auth()->user()->role['name'] === 'Super Admin'
            ? session('branch_id')
            : auth()->user()->branch_id;

        // Fetch AMC customers
        $amcCustomers = AmcCustomer::with(['customer', 'amc'])
            ->where('branch_id', $branch_id)
            ->where(function ($query) {
                $query->whereIn('status', ['on', 'report', 'complete'])
                    ->orWhereNull('status');
            })
            ->get();

        $finalData = [];

        foreach ($amcCustomers as $item) {

            if (!$item->amc) continue;

            // AMC duration in months
            $totalMonths = $item->amc->year * 12;

            // AMC start date = created_at
            $startDate = \Carbon\Carbon::parse($item->date);

            // AMC end date
            $amcEndDate = $startDate->copy()->addMonths($totalMonths);

            // Check expired
            if (now()->greaterThan($amcEndDate)) {

                $item->amc_end_date = $amcEndDate->toDateString();
                $item->amc_start_date = $startDate->toDateString();
                $item->duration_years = $item->amc->year;

                $finalData[] = $item;
            }
        }

        return view('supportdashboard::amc_customer.outservice', [
            'amccustomer' => $finalData
        ]);
    }


    public function dashboard()
    {
        if (auth()->user()->role->name === 'Super Admin') {
            $branchId = session('branch_id');
        } else {
            $branchId = auth()->user()->branch_id;
        }

        $totalcustomer = CustomerTicket::where('branch_id', $branchId)->where('amc_type', 'yes')->count();
        $queuecount = CustomerTicket::where('branch_id', $branchId)->where('amc_type', 'yes')->where('status', 'queue')->count();
        $assigncount = CustomerTicket::where('branch_id', $branchId)->where('amc_type', 'yes')->where('status', 'assign')->count();
        $completecount = CustomerTicket::where('branch_id', $branchId)->where('amc_type', 'yes')->where('status', 'complete')->where('due_amount', 0)->count();

        return view('supportdashboard::amc_customer.dashboard', compact('totalcustomer', 'queuecount', 'assigncount', 'completecount'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branch_id = session('branch_id');
        } else {
            $branch_id = auth()->user()->branch_id;
        }
        $id = $request->id;

        $ticket = CustomerTicket::create([
            'amc_customer_id'     => $id,
            'customer_id'     => $request->customer_id,
            'support_type'    => $request->support_type,
            'priority'        => $request->priority,
            'branch_id'        => $branch_id,
            'amc'             => $request->amc,
            'warranty'        => $request->warranty,
            'amc_type'     => 'yes',
            'message'        => $request->message,
            'status'          => 'queue',
        ]);

        if ($request->customer_id) {
            $customer = Customer::findOrFail($request->customer_id);
            $customer->ticket_status = 'queue';
            $customer->save();

            $ticket->register_type = 'yes';
            $ticket->save();
        }

        // $amc = AmcCustomer::where('customer_id', $request->customer_id)->first();
        // if ($amc) {
        //     $amc->status = 'off';
        //     $amc->save();

        //     $ticket->amc_type = 'yes';
        //     $ticket->amc_customer_id = '$request->customer_id';

        //     $ticket->save();
        // }


        $amccustomer = AmcCustomer::findOrFail($id);
        if ($amccustomer) {
            $amccustomer->last_date = now();
            $amccustomer->status = 'off';
            $amccustomer->save();
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
        $customers = CustomerTicket::with(['amc', 'customer', 'amccustomer'])->where('branch_id', $branch_id)->where('amc_type', 'yes')->where('status', 'queue')->latest()->get();
        foreach ($customers as $customer) {
            $customer->created_time = $this->formatTimeDifference($customer->created_at);
        }

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

    public function assignStore(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        // Ticket (safe)
        $ticket = CustomerTicket::find($id);

        if (!$ticket) {
            return back()->with('error', 'Ticket not found.');
        }

        // User (safe)
        $user = User::find($request->user_id);

        // Update ticket
        $ticket->assign_to = $request->user_id;
        $ticket->message = $request->message;
        $ticket->status = 'assign';
        $ticket->save();

        // Create note
        TicketNote::create([
            'ticket_id' => $ticket->id,
            'note' => $request->message,
        ]);

        // Customer (safe)
        if ($request->customer_id) {
            $customer = Customer::find($request->customer_id);
            if ($customer) {
                $customer->ticket_status = 'assign';
                $customer->save();
            }
        }

        // AMC Customer (safe)
        // if ($ticket->amc_customer_id) {
        //     $amccustomer = AmcCustomer::find($ticket->amc_customer_id);

        //     if ($amccustomer) {
        //         $amccustomer->last_date = now();
        //         $amccustomer->status = 'assign';
        //         $amccustomer->save();
        //     }
        // }

        // Log
        Log::create([
            'perform'   => auth()->user()->name . ' Assign Lead to : '
                . $user->name . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        return redirect()->route('amccustomer-ticket.assign')
            ->with('success', 'Ticket assigned successfully.');
    }


    public function assign()
    {
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branch_id = session('branch_id');
        } else {
            $branch_id = auth()->user()->branch_id;
        }
        $users = User::where('branch_id', $branch_id)->get();
        $customers = CustomerTicket::with(['amc', 'customer', 'user', 'amccustomer'])->where('branch_id', $branch_id)->where('amc_type', 'yes')->where('status', 'assign')->latest()->get();
        foreach ($customers as $customer) {
            $customer->created_time = $this->formatTimeDifference($customer->updated_at);
        }
        return view('supportdashboard::amc_customer.assign', compact('customers', 'users'));
    }

    public function create($id)
    {
        $customer = CustomerTicket::with(['amc', 'customer', 'branch', 'amccustomer'])->findOrFail($id);;
        // $customer = Customer::with('lead')->findOrFail($id);
        $customerAccessories = CustomerAccessory::with('accessory')->get();

        return view('supportdashboard::amc_customer.create', compact(
            'customer',
            'customerAccessories',
        ));
    }

    public function storeamccustomer(Request $request, $id): RedirectResponse
    {
        // dd($request->all());
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branch_id = session('branch_id');
        } else {
            $branch_id = auth()->user()->branch_id;
        }
        // dd($request->all());
        DB::beginTransaction();

        try {
            $ticket = CustomerTicket::findOrFail($id);
            $username = $request->username; // the generated username from frontend

            $originalUsername = $username;
            $counter = 1;

            // Check in customers table
            while (Customer::where('user_name', $username)->exists()) {
                $username = $originalUsername . $counter;
                $counter++;
            }
            // 🧾 Handle Receipts
            if ($request->hasFile('cash_receipt')) {
                $cashFile = $request->file('cash_receipt');
                $cashFileName = $cashFile->getClientOriginalName(); // keep original name
                $cashFile->move(public_path('receipts'), $cashFileName); // save to public/receipts
            } else {
                $cashFileName = Null;
            }
            //

            //

            if ($request->hasFile('online_receipt')) {
                $onlineFile = $request->file('online_receipt');
                $onlineFileName = $onlineFile->getClientOriginalName();
                $onlineFile->move(public_path('receipts'), $onlineFileName);
            } else {
                $onlineFileName = Null;
            }

            if ($request->hasFile('cheque_receipt')) {
                $chequeFile = $request->file('cheque_receipt');
                $chequeFileName = $chequeFile->getClientOriginalName();
                $chequeFile->move(public_path('receipts'), $chequeFileName);
            } else {
                $chequeFileName = Null;
            }

            $paidAmount = ($request->cash_amount ?? 0) + ($request->online_amount ?? 0) + ($request->cheque_amount ?? 0);
            $grandTotal = $request->grand_total;
            if ($request->service_type == 'free') {
                $paidAmount = 0;
                $dueAmount = 0;
            } else {
                $dueAmount = $request->remaining_amount;
            }

            if ($request->hasFile('product_document')) {
                $productFile = $request->file('product_document');
                $productFileName = $productFile->getClientOriginalName(); // keep original name
                $productFile->move(public_path('receipts'), $productFileName); // save to public/receipts
            } else {
                $productFileName = NULL;
            }
            if ($request->hasFile('warranty_card')) {
                $warrantyFile = $request->file('warranty_card');
                $warrantyFileName = $warrantyFile->getClientOriginalName(); // keep original name
                $warrantyFile->move(public_path('receipts'), $warrantyFileName); // save to public/receipts
            } else {
                $warrantyFileName = NULL;
            }


            $totalAmount = $grandTotal + $request->service_charge;

            // 🧩 Update Customer
            $ticket->update([
                'user_name'         => $username,
                'customer_name'      => $request->name,
                'contact'      => $request->mobile,
                'landline'      => $request->landline,
                'address'      => $request->address,
                'email'      => $request->email,
                'install_date'      => $request->install_date,
                'branch_id'         => $branch_id,
                'service_type'      => $request->service_type,
                'service_charge'      => $request->service_charge ?? 0,
                'amount'      => $request->grand_total,
                'total_amount'      => $totalAmount,
                'paid_amount'       => $paidAmount,
                'due_amount'        => $dueAmount,

                // 🧾 Payment Section
                'payment_status'    => $request->payment_status,
                'payment_method'    => $request->method,

                // 💰 Cash Payment
                'cash_amount'       => $request->cash_amount,
                'cash_receipt'      => $cashFileName,

                // 💳 Online Payment
                'online_amount'     => $request->online_amount,
                'online_receipt'    => $onlineFileName,

                // 🧾 Cheque Payment
                'cheque_amount'     => $request->cheque_amount,
                'cheque_number'     => $request->cheque_number,
                'cheque_receipt'    => $chequeFileName,


                'message'           => $request->remarks,
                'status'           => 'complete',


                'product_document'    => $productFileName,
                'warranty_card'    => $warrantyFileName,
            ]);


            if ($request->customer_id) {
                $customer = Customer::findOrFail($request->customer_id);
                $customer->ticket_status = 'complete';
                $customer->save();
            }

            $amccustomer = AmcCustomer::where('customer_id', $request->customer_id)->first();
            if ($amccustomer) {
                $amccustomer->last_date = now();
                $amccustomer->status = 'on';
                $amccustomer->save();
            }

            // 🔁 Store Accessories
            if ($request->has('accessories_id') && is_array($request->accessories_id)) {
                foreach ($request->accessories_id as $index => $accessoryId) {
                    CustomerTicketAccessory::create([
                        'ticket_id' => $ticket->id,
                        'created_by' => auth()->id(),
                        'branch_id' => $branch_id,
                        'customer_id' => $request->customer_id,
                        'accessory_id' => $accessoryId,
                        'accessory_qty' => $request->accessories_qty[$index] ?? 0,
                        'accessory_price' => $request->accessories_price[$index] ?? 0,
                        'accessory_total' => $request->accessories_total[$index] ?? 0,
                    ]);
                }
            }



            if ($paidAmount > 0) {
                CustomerTicketPayment::create([
                    'ticket_id'        => $ticket->id,
                    'branch_id'      => $branch_id,
                    'customer_id'    => $request->customer_id,
                    'created_by'     => $request->converted_by ?? auth()->id(),
                    'paid_amount'    => $paidAmount,
                    'payment_method' => $request->method,

                    // 💰 Cash Payment
                    'cash_amount'       => $request->cash_amount,
                    'cash_receipt'      => $cashFileName,

                    // 💳 Online Payment
                    'online_amount'     => $request->online_amount,
                    'online_receipt'    => $onlineFileName,

                    // 🧾 Cheque Payment
                    'cheque_amount'     => $request->cheque_amount,
                    'cheque_number'     => $request->cheque_number,
                    'cheque_receipt'    => $chequeFileName,
                    'status'         => 'paid',


                ]);
            }


            TicketNote::create([
                'ticket_id' => $ticket->id,
                'note' => $request->message,
            ]);
            // Log::create([
            //     'perform'   => auth()->user()->name . ' Convert Lead Into Client : '
            //         . $lead->name . ' at ' . now(),
            //     'user_id'   => auth()->user()->id,
            //     'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            //     'url'       => url()->current(),
            // ]);

            DB::commit();

            return redirect()->route('amccustomer-ticket.report')
                ->with('success', 'Ticket    created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating installation: ' . $e->getMessage());
        }
    }

    public function report()
    {
        // dd('hello');
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branch_id = session('branch_id');
        } else {
            $branch_id = auth()->user()->branch_id;
        }
        $users = User::where('branch_id', $branch_id)->get();
        $customers = CustomerTicket::with(['amc', 'customer', 'user', 'amccustomer'])->where('branch_id', $branch_id)->where('amc_type', 'yes')->where('status', 'complete')->latest()->get();

        return view('supportdashboard::amc_customer.report', compact('customers', 'users'));
    }

    public function complete()
    {
        // dd('hii');
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branch_id = session('branch_id');
        } else {
            $branch_id = auth()->user()->branch_id;
        }
        $users = User::where('branch_id', $branch_id)->get();
        $customers = CustomerTicket::with(['amc', 'customer', 'user'])->where('branch_id', $branch_id)->where('type', 'amc')->where('status', 'complete')->where('due_amount', 0)->latest()->get();

        return view('supportdashboard::amc_customer.complete', compact('customers', 'users'));
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
    private function formatTimeDifference($dateTime)
    {
        if (!$dateTime) {
            return 'N/A';
        }

        $time = \Carbon\Carbon::parse($dateTime);
        $now = \Carbon\Carbon::now();

        $diffInSeconds = $now->diffInSeconds($time);

        $years = floor($diffInSeconds / (365 * 24 * 60 * 60));
        $months = floor(($diffInSeconds % (365 * 24 * 60 * 60)) / (30 * 24 * 60 * 60));
        $days = floor(($diffInSeconds % (30 * 24 * 60 * 60)) / (24 * 60 * 60));
        $hours = floor(($diffInSeconds % (24 * 60 * 60)) / 3600);
        $minutes = floor(($diffInSeconds % 3600) / 60);

        $parts = [];

        if ($years > 0) {
            $parts[] = $years . ' year' . ($years > 1 ? 's' : '');
            if ($months > 0) $parts[] = $months . ' month' . ($months > 1 ? 's' : '');
            if ($days > 0) $parts[] = $days . ' day' . ($days > 1 ? 's' : '');
        } elseif ($months > 0) {
            $parts[] = $months . ' month' . ($months > 1 ? 's' : '');
            if ($days > 0) $parts[] = $days . ' day' . ($days > 1 ? 's' : '');
            if ($hours > 0) $parts[] = $hours . ' hour' . ($hours > 1 ? 's' : '');
        } elseif ($days > 0) {
            $parts[] = $days . ' day' . ($days > 1 ? 's' : '');
            if ($hours > 0) $parts[] = $hours . ' hour' . ($hours > 1 ? 's' : '');
            if ($minutes > 0) $parts[] = $minutes . ' minute' . ($minutes > 1 ? 's' : '');
        } else {
            if ($hours > 0) $parts[] = $hours . ' hour' . ($hours > 1 ? 's' : '');
            if ($minutes > 0) $parts[] = $minutes . ' minute' . ($minutes > 1 ? 's' : '');
        }

        return $parts ? implode(' ', $parts) . ' ago' : 'Just now';
    }
}
