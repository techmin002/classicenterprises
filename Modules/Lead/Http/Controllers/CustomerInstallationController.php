<?php

namespace Modules\Lead\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Employee\Entities\Employee;
use Modules\Lead\Entities\Customer;
use Modules\Lead\Entities\CustomerAccessory;
use Modules\Lead\Entities\CustomerPayment;
use Modules\Lead\Entities\CustomerProduct;
use Modules\Lead\Entities\Lead;
use Modules\Product\Entities\Machinery;
use Modules\EMISystem\Entities\EmiPlan;
use Modules\Lead\Entities\EmiCustomer;
use Illuminate\Support\Facades\DB;

class CustomerInstallationController extends Controller
{
    const STATUS_QUEUE = 'installation_queue';
    const STATUS_REPORT = 'installation_report';
    const STATUS_COMPLETE = 'installation_complete';
    const STATUS_EMI = 'emi_process';

    /**
     * Display installation queue
     */
    public function index($sale_type)
    {
        $customers = $this->getCustomersByStatus(self::STATUS_QUEUE, $sale_type);
        $saleType = ucfirst($sale_type);
        return view('lead::installation.queue', compact('customers', 'saleType'));
    }

    /**
     * Display installation reports
     */
    public function installationReport($sale_type)
    {
        $customers = $this->getCustomersByStatus(self::STATUS_REPORT, $sale_type);
        $saleType = ucfirst($sale_type);
        return view('lead::installation.reports', compact('customers', 'saleType'));
    }

    /**
     * Display completed installations
     */
    public function installationComplete($sale_type)
    {
        $customers = $this->getCustomersByStatus(self::STATUS_COMPLETE, $sale_type);
        $saleType = ucfirst($sale_type);
        return view('lead::installation.complete', compact('customers', 'saleType'));
    }

    /**
     * Show installation creation form
     */
    public function create($id)
    {
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

        DB::beginTransaction();

        try {
            $lead = Lead::findOrFail($request->lead_id);
            $customer = Customer::firstOrCreate(
                ['lead_id' => $request->lead_id],
                ['branch_id' => $lead->branch_id, 'created_by' => auth()->id()]
            );

            // Handle Products
            $this->processProducts($request, $customer, $lead);

            // Handle Accessories
            $this->processAccessories($request, $customer, $lead);

            // Update Lead
            $lead->update($request->only(['name', 'mobile', 'email', 'address']) + ['status' => 'convert']);

            // Process Payment and determine status
            $status = $this->processPaymentAndDetermineStatus($request, $customer, $lead);

            // Update Customer
            $customer->update([
                'converted_by' => $request->converted_by,
                'install_date' => $request->install_date,
                'branch_id' => $lead->branch_id,
                'total_amount' => $request->grand_total,
                'paid_amount' => $request->paid_amount ?? 0,
                'due_amount' => $request->grand_total - ($request->paid_amount ?? 0),
                'customer_type' => 'indoor',
                'status' => $status,
            ]);

            DB::commit();

            return redirect()->route('installation-queue.index', ['sale_type' => $lead->sales_type])
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
        $customer = Customer::where('id', $id)->with('lead', 'payments')->first();
        return view('lead::installation.payment', compact('customer'));
    }

    /**
     * Show customer details
     */
    public function customerDetails($id)
    {
        $customer = Customer::where('id', $id)->with('lead', 'products', 'accessories')->first();
        return view('lead::installation.customer_details', compact('customer'));
    }

    /***********************
     * PRIVATE METHODS
     ***********************/

    /**
     * Get customers by status and sale type
     */
    private function getCustomersByStatus($status, $saleType)
    {
        $query = Customer::with('lead')
            ->where('status', $status)
            ->where('sales_type', $saleType);

        if (auth()->user()->role['name'] != 'Super Admin') {
            $query->where('branch_id', auth()->user()->branch_id);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Process products for installation
     */
    private function processProducts($request, $customer, $lead)
    {
        if ($request->has('products_id') && is_array($request->products_id)) {
            foreach ($request->products_id as $index => $productId) {
                if ($productId) {
                    $existing = CustomerProduct::where('customer_id', $customer->id)
                        ->where('product_id', $productId)
                        ->first();

                    $qty = $request->products_qty[$index] ?? 0;
                    $price = $request->products_price[$index] ?? 0;

                    if ($existing) {
                        $existing->update([
                            'product_qty' => $existing->product_qty + $qty,
                            'product_price' => $price,
                            'product_total' => ($existing->product_qty + $qty) * $price,
                        ]);
                    } else {
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
    }

    /**
     * Process accessories for installation
     */
    private function processAccessories($request, $customer, $lead)
    {
        if ($request->has('accessories_id') && is_array($request->accessories_id)) {
            foreach ($request->accessories_id as $index => $accessoryId) {
                if ($accessoryId) {
                    $existing = CustomerAccessory::where('customer_id', $customer->id)
                        ->where('accessory_id', $accessoryId)
                        ->first();

                    $qty = $request->accessories_qty[$index] ?? 0;
                    $price = $request->accessories_price[$index] ?? 0;

                    if ($existing) {
                        $existing->update([
                            'accessory_qty' => $existing->accessory_qty + $qty,
                            'accessory_price' => $price,
                            'accessory_total' => ($existing->accessory_qty + $qty) * $price,
                        ]);
                    } else {
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
}
