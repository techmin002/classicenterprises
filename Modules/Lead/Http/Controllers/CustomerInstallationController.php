<?php

namespace Modules\Lead\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\EMISystem\Entities\EmiPlan;
use Modules\Employee\Entities\Employee;
use Modules\Lead\Entities\Customer;
use Modules\Lead\Entities\CustomerAccessory;
use Modules\Lead\Entities\CustomerNote;
use Modules\Lead\Entities\CustomerPayment;
use Modules\Lead\Entities\CustomerProduct;
use Modules\Lead\Entities\EmiCustomer;
use Modules\Lead\Entities\Lead;
use Modules\Lead\Entities\Skim;
use Modules\Product\Entities\Machinery;
use Illuminate\Support\Facades\Gate;

class CustomerInstallationController extends Controller
{
    const STATUS_QUEUE = 'installation_queue';
    const STATUS_REPORT = 'installation_report';
    const STATUS_COMPLETE = 'installation_complete';
    const STATUS_EMI = 'emi_process';

    /**
     * Display installation queue
     */
    public function index(Request $request, $sale_type)
    {
        abort_if(Gate::denies('access_installments'), 403);

        $users = User::where('branch_id', session('branch_id'))->get();

        // Get query builder
        $customers = $this->getCustomersByStatus(self::STATUS_QUEUE, $sale_type);

        // Predefined filters
        if ($request->filter == '7days') {
            $customers->where('updated_at', '>=', now()->subDays(7));
        } elseif ($request->filter == '15days') {
            $customers->where('updated_at', '>=', now()->subDays(15));
        } elseif ($request->filter == '1month') {
            $customers->where('updated_at', '>=', now()->subMonth());
        }

        // Custom date filter
        if ($request->filled(['start_date', 'end_date'])) {
            $start = $request->start_date . ' 00:00:00';
            $end = $request->end_date . ' 23:59:59';
            $customers->whereBetween('updated_at', [$start, $end]);
        }

        // Get collection after filters
        $customers = $customers->orderBy('updated_at', 'desc')->get();

        // Formatted time
        foreach ($customers as $customer) {
            $customer->formatted_time = $this->formatTimeDifference($customer->updated_at);
        }

        $saleType = $sale_type;

        return view('lead::installation.queue', compact('customers', 'saleType', 'users'));
    }




    /**
     * Display installation reports
     */
    public function installationReport(Request $request, $sale_type)
    {
        // Get query builder from getCustomersByStatus (do NOT call get() inside that method)
        $customers = $this->getCustomersByStatus(self::STATUS_REPORT, $sale_type);

        // ✅ Predefined filters
        if ($request->filter == '7days') {
            $customers->where('updated_at', '>=', now()->subDays(7));
        } elseif ($request->filter == '15days') {
            $customers->where('updated_at', '>=', now()->subDays(15));
        } elseif ($request->filter == '1month') {
            $customers->where('updated_at', '>=', now()->subMonth());
        }

        // ✅ Custom date filter
        if ($request->filled(['start_date', 'end_date'])) {
            $start = $request->start_date . ' 00:00:00';
            $end = $request->end_date . ' 23:59:59';
            $customers->whereBetween('updated_at', [$start, $end]);
        }

        // ✅ Order by latest first and get collection
        $customers = $customers->orderBy('updated_at', 'desc')->get();

        // ✅ Add formatted time
        foreach ($customers as $customer) {
            $customer->formatted_time = $this->formatTimeDifference($customer->updated_at);
        }

        $saleType = $sale_type;

        return view('lead::installation.reports', compact('customers', 'saleType'));
    }



    /**
     * Display completed installations
     */
    public function installationComplete(Request $request, $sale_type)
    {
        $saleType = $sale_type;
        $statusComplete = self::STATUS_COMPLETE;

        // Start query
        $customers = Customer::where('sales_type', $sale_type)
            ->where(function ($query) use ($statusComplete) {
                $query->where('status', $statusComplete)
                    ->orWhere('due_amount', 0);
            });

        // ✅ Predefined filters
        if ($request->filter == '7days') {
            $customers->where('updated_at', '>=', now()->subDays(7));
        } elseif ($request->filter == '15days') {
            $customers->where('updated_at', '>=', now()->subDays(15));
        } elseif ($request->filter == '1month') {
            $customers->where('updated_at', '>=', now()->subMonth());
        }

        // ✅ Custom date filter
        if ($request->filled(['start_date', 'end_date'])) {
            $start = $request->start_date . ' 00:00:00';
            $end = $request->end_date . ' 23:59:59';
            $customers->whereBetween('updated_at', [$start, $end]);
        }

        // ✅ Order latest first and get
        $customers = $customers->orderBy('updated_at', 'desc')->get();

        // ✅ Add formatted time
        foreach ($customers as $customer) {
            $customer->formatted_time = $this->formatTimeDifference($customer->updated_at);
        }

        return view('lead::installation.complete', compact('customers', 'saleType'));
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



    /**
     * Show installation creation form
     */
    public function create($id)
    {
        abort_if(Gate::denies('create_installments'), 403);

        $emiPlans = EmiPlan::where('status', 1)->get();
        $customer = Customer::with('lead')->findOrFail($id);
        $leadby = User::select('name', 'id')->where('id', $customer->lead['created_by'])->first();
        $staffs = User::where('branch_id', $customer['branch_id'])->get();
        $customerMachines = CustomerProduct::where('customer_id', $customer['id'])->with('product')->get();
        $customerAccessories = CustomerAccessory::where('customer_id', $customer['id'])->with('accessory')->get();




        return view('lead::installation.create', compact(
            'customer',
            'customerMachines',
            'customerAccessories',
            'staffs',
            'leadby',
            'emiPlans'
        ));
    }

    /**
     * Store new installation
     */
    public function store(Request $request): RedirectResponse
    {
        // dd("STORE");
        // dd($request->all());
        DB::beginTransaction();

        try {
            $lead = Lead::findOrFail($request->lead_id);
            $customer = Customer::firstOrCreate(
                ['lead_id' => $request->lead_id],
                ['branch_id' => $lead->branch_id, 'created_by' => auth()->id()]
            );
            // dd($lead);

            // Handle Products
            CustomerProduct::where('customer_id', $customer->id)->delete();
            $this->processProducts($request, $customer, $lead);

            // Handle Accessories
            CustomerAccessory::where('customer_id', $customer->id)->delete();
            $this->processAccessories($request, $customer, $lead);

            // Update Lead
            $lead->update($request->only(['name', 'mobile', 'email', 'address']) + ['status' => 'convert']);

            // Process Payment and determine status
            $status = $this->processPaymentAndDetermineStatus($request, $customer, $lead);


            $isGifted = $request->is_gifted == 1;

            $username = $request->username; // the generated username from frontend

            $originalUsername = $username;
            $counter = 1;

            // Check in customers table
            while (Customer::where('user_name', $username)->exists()) {
                // dd('HiI');
                $username = $originalUsername . $counter;
                $counter++;
            }
            // 🧾 Handle Receipts
            if ($request->hasFile('cash_receipt')) {
                $cashFile = $request->file('cash_receipt');
                $cashFileName = $cashFile->getClientOriginalName(); // keep original name
                $cashFile->move(public_path('receipts'), $cashFileName); // save to public/receipts
            } else {
                $cashFileName = $customer->cash_receipt;
            }

            if ($request->hasFile('online_receipt')) {
                $onlineFile = $request->file('online_receipt');
                $onlineFileName = $onlineFile->getClientOriginalName();
                $onlineFile->move(public_path('receipts'), $onlineFileName);
            } else {
                $onlineFileName = $customer->online_receipt;
            }

            if ($request->hasFile('cheque_receipt')) {
                $chequeFile = $request->file('cheque_receipt');
                $chequeFileName = $chequeFile->getClientOriginalName();
                $chequeFile->move(public_path('receipts'), $chequeFileName);
            } else {
                $chequeFileName = $customer->cheque_receipt;
            }

            $paidAmount = ($request->cash_amount ?? 0) + ($request->online_amount ?? 0) + ($request->cheque_amount ?? 0);
            $grandTotal = $request->grand_total;
            if ($request->is_gifted) {
                $paidAmount = 0;
                $dueAmount = 0;
                $status = 'installation_complete';
            } else {
                $dueAmount = $request->remaining_amount;
                $status = 'installation_report';
            }

            if ($request->hasFile('product_document')) {
                $productFile = $request->file('product_document');
                $productFileName = $productFile->getClientOriginalName(); // keep original name
                $productFile->move(public_path('receipts'), $productFileName); // save to public/receipts
            } else {
                $productFileName = $customer->product_document;
            }
            if ($request->hasFile('warranty_card')) {
                $warrantyFile = $request->file('warranty_card');
                $warrantyFileName = $warrantyFile->getClientOriginalName(); // keep original name
                $warrantyFile->move(public_path('receipts'), $warrantyFileName); // save to public/receipts
            } else {
                $warrantyFileName = $customer->warranty_card;
            }

            $totalAmount = $grandTotal - $request->exchange_amount;

            // 🧩 Update Customer
            $customer->update([
                'user_name'         => $username,
                'name'      => $request->name,
                'mobile'      => $request->mobile,
                'landline'      => $request->landline,
                'address'      => $request->address,
                'email'      => $request->email,
                'install_date'      => $request->install_date,
                'branch_id'         => $lead->branch_id,
                'total_amount'      => $totalAmount,
                'paid_amount'       => $paidAmount,
                'due_amount'        => $dueAmount,
                'customer_type'     => 'indoor',
                'message'           => $request->remarks,
                'ticket_status'     => 'on',
                'status'            => $status,
                'gifted'            => $request->is_gifted,
                'warranty_in'       => $request->warranty_from,
                'warranty_out'      => $request->warranty_to,
                'warranty_lifetime' => $request->has('lifetime') ? 1 : 0,
                'warranty__service_date'       => $request->install_date,


                'product_document'    => $productFileName,
                'warranty_card'    => $warrantyFileName,

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

            ]);


            if ($paidAmount > 0) {
                CustomerPayment::create([
                    'lead_id'        => $customer->lead_id,
                    'branch_id'      => $customer->branch_id,
                    'customer_id'    => $customer->id,
                    'created_by'     => $customer->converted_by ?? auth()->id(),
                    'paid_amount'    => $customer->paid_amount ?? 0,
                    'payment_method' => $customer->payment_method ?? null,
                    'cash_amount'    => $customer->cash_amount ?? 0,
                    'cash_receipt'   => $customer->cash_receipt ?? null,
                    'online_amount'  => $customer->online_amount ?? 0,
                    'online_receipt' => $customer->online_receipt ?? null,
                    'cheque_amount'  => $customer->cheque_amount ?? 0,
                    'cheque_number'  => $customer->cheque_number ?? null,
                    'cheque_receipt' => $customer->cheque_receipt ?? null,
                    'status'         => 'paid',
                ]);
            }


            CustomerNote::create([
                'lead_id' => $customer->lead_id,
                'customer_id' => $customer->id,
                'note' => $request->remarks,
            ]);
            Log::create([
                'perform'   => auth()->user()->name . ' Convert Lead Into Client : '
                    . $lead->name . ' at ' . now(),
                'user_id'   => auth()->user()->id,
                'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
                'url'       => url()->current(),
            ]);

            DB::commit();

            return redirect()->route('installation.reports', ['sale_type' => $lead->sales_type])
                ->with('success', 'Installation created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating installation: ' . $e->getMessage());
        }
    }

    /**
     * Show customer payment details
     */
    public function customerPaymentDetails($id)
    {
        abort_if(Gate::denies('show_installments'), 403);

        // dd('hello');
        $customer = Customer::where('id', $id)->with('lead', 'payments')->first();
        return view('lead::installation.payment', compact('customer'));
    }

    /**
     * Show customer details
     */
    // public function customerDetails($id)
    // {
    //     $customer = Customer::where('id', $id)->with('lead', 'products', 'accessories')->first();
    //     return view('lead::installation.customer_details', compact('customer'));
    // }

    public function customerDetails($id)
    {
        $customer = Customer::with('lead', 'products', 'accessories')
            ->where('id', $id)
            ->first();

        if (!$customer) {
            abort(404, 'Customer not found');
        }

        // Get related skims
        $skims = Skim::where('lead_id', $customer->lead_id)->get();

        // Add formatted time
        $customer->formatted_time = $this->formatTimeDifference($customer->updated_at);

        return view('lead::details.index', compact('customer', 'skims'));
    }

    public function customerDocuments($id)
    {
        $customer = Customer::where('id', $id)->with('lead', 'products', 'accessories')->first();
        return view('lead::installation.document', compact('customer'));
    }

    /***********************
     * PRIVATE METHODS
     ***********************/

    /**
     * Get customers by status and sale type
     */
    private function getCustomersByStatus($status, $saleType)
    {
        $query = Customer::with('lead', 'products')
            ->where('status', $status)
            ->where('branch_id', session('branch_id'))
            ->where('sales_type', $saleType);

        if (auth()->user()->role['name'] != 'Super Admin') {
            $query->where('branch_id', auth()->user()->branch_id);
        }

        return $query;
    }


    /**
     * Process products for installation
     */
    private function processProducts($request, $customer, $lead)
    {
        if ($request->has('products_id') && is_array($request->products_id)) {
            foreach ($request->products_id as $index => $productId) {
                if ($productId) {
                    $qty = $request->products_qty[$index] ?? 0;
                    $price = $request->products_price[$index] ?? 0;

                    CustomerProduct::create([
                        'lead_id' => $request->lead_id,
                        'branch_id' => $lead->branch_id,
                        'customer_id' => $customer->id,
                        'created_by' => auth()->id(),
                        'product_id' => $productId,
                        'remarks' => $request->remarks,
                        'product_qty' => $qty,
                        'product_price' => $price,
                        'product_total' => $request->products_total[$index] ?? ($qty * $price),
                        'status' => self::STATUS_QUEUE,
                    ]);
                }
            }
        }
    }

    /**
     * Process accessories for installation
     */
    private function processAccessories($request, $customer, $lead)
    {
        if ($request->has('accessories_id') && is_array($request->accessories_id)) {
            foreach ($request->accessories_id as $index => $accessoryId) {
                if ($accessoryId) {
                    $qty = $request->accessories_qty[$index] ?? 0;
                    $price = $request->accessories_price[$index] ?? 0;

                    CustomerAccessory::create([
                        'customer_id' => $customer->id,
                        'lead_id' => $lead->id,
                        'created_by' => auth()->id(),
                        'branch_id' => $lead->branch_id,
                        'accessory_id' => $accessoryId,
                        'accessory_qty' => $qty,
                        'accessory_price' => $price,
                        'accessory_total' => $request->accessories_total[$index] ?? ($qty * $price),
                    ]);
                }
            }
        }
    }

    /**
     * Process payment and determine customer status
     */
    private function processPaymentAndDetermineStatus($request, $customer, $lead)
    {

        $status = self::STATUS_QUEUE;

        if ($request->emi_id) {
            $status = $this->processEmiPayment($request, $customer, $lead);
        } else {
            $status = $this->processRegularPayment($request, $customer, $lead);
        }

        return $status;
    }

    /**
     * Process EMI payment
     */
    private function processEmiPayment($request, $customer, $lead)
    {
        EmiCustomer::create([
            'customer_id' => $customer->id,
            'emi_plan_id' => $request->emi_id,
            'down_payment' => $request->down_payment ?? 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'monthly_pay' => $request->monthly_pay,
            'document' => $request->hasFile('document')
                ? $request->file('document')->store('emi_documents', 'public')
                : null,
            'status' => $request->status ?? 1,
        ]);

        if ($request->down_payment > 0) {
            CustomerPayment::create([
                'created_by' => auth()->id(),
                'branch_id' => $lead->branch_id,
                'lead_id' => $request->lead_id,
                'paid_amount' => $request->down_payment,
                'customer_id' => $customer->id,
                'payment_method' => 'emi_downpayment',
                'payment_date' => now(),
            ]);
        }

        return self::STATUS_EMI;
    }

    /**
     * Process regular payment
     */
    private function processRegularPayment($request, $customer, $lead)
    {
        if ($request->paid_amount > 0) {
            CustomerPayment::create([
                'created_by' => auth()->id(),
                'branch_id' => $lead->branch_id,
                'lead_id' => $request->lead_id,
                'paid_amount' => $request->paid_amount,
                'customer_id' => $customer->id,
                'payment_method' => $request->method,
                'payment_date' => $request->paid_date ?? now(),
            ]);

            if ($request->grand_total == $request->paid_amount) {
                return self::STATUS_COMPLETE;
            }

            return self::STATUS_REPORT;
        }

        return self::STATUS_QUEUE;
    }


    public function assignindex(Request $request, $sale_type)
    {
        $users = User::where('branch_id', session('branch_id'))->get();

        // Start query (no get yet)
        $customers = Customer::where('status', 'installation_assign')
            ->where('sales_type', $sale_type)
            ->where('branch_id', session('branch_id'))
            ->with('assignLead');

        // ✅ Predefined filters
        if ($request->filter == '7days') {
            $customers->where('updated_at', '>=', now()->subDays(7));
        } elseif ($request->filter == '15days') {
            $customers->where('updated_at', '>=', now()->subDays(15));
        } elseif ($request->filter == '1month') {
            $customers->where('updated_at', '>=', now()->subMonth());
        }

        // ✅ Custom date filter
        if ($request->filled(['start_date', 'end_date'])) {
            $start = $request->start_date . ' 00:00:00';
            $end = $request->end_date . ' 23:59:59';
            $customers->whereBetween('updated_at', [$start, $end]);
        }

        // ✅ Order by latest first and get collection
        $customers = $customers->orderBy('updated_at', 'desc')->get();

        // ✅ Add formatted time
        foreach ($customers as $customer) {
            $customer->formatted_time = $this->formatTimeDifference($customer->updated_at);
        }

        $saleType = $sale_type;

        return view('lead::installation.assign', compact('customers', 'saleType', 'users'));
    }




    public function assignStore(Request $request, $id)
    {
        // dd($request->all());

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $customer = Customer::findOrFail($id);

        $customer->assign_to = $request->user_id;
        $user = User::findOrFail($request->user_id);
        $customer->message = $request->message;
        $customer->status = 'installation_assign';
        $customer->save();

        CustomerNote::create([
            'lead_id' => $customer->lead_id,
            'customer_id' => $customer->id,
            'note' => $request->message,
        ]);

        Log::create([
            'perform'   => auth()->user()->name . ' Assign Lead to : '
                . $user->name . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        // return back()->with('success', 'Lead assigned successfully.');
        return redirect()->route('installation-assign.index', ['sale_type' => $customer->sales_type])
            ->with('success', 'Lead assigned successfully.');
    }


    public function messageupdate(Request $request, $id)
    {
        // dd($id);
        // dd($request->all());
        $customer = Customer::findOrFail($id);

        // $user = User::findOrFail($request->user_id);
        $customer->message = $request->note;
        $customer->save();

        CustomerNote::create([
            'lead_id' => $customer->lead_id,
            'customer_id' => $customer->id,
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



    public function destroy($id)
    {
        // dd('hii');
        $customer = Customer::findOrfail($id);
        if ($customer) {
            $customer->delete();
            return back()->with('success', 'Customer Delete successfully');
        } else {
            return back()->with('error', 'Customer Not Found');
        }
        Log::create([
            'perform'   => auth()->user()->name . ' Deleted. ' . $customer->name . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
    }
}
