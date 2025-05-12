<?php

namespace Modules\Lead\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Employee\Entities\Employee;
use Modules\Lead\Entities\Customer;
use Modules\Lead\Entities\CustomerAccessory;
use Modules\Lead\Entities\CustomerPayment;
use Modules\Lead\Entities\CustomerProduct;
use Modules\Lead\Entities\Lead;
use Modules\Product\Entities\Machinery;

class CustomerInstallationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($sale_type)
    {
        if ($sale_type == 'retailler') {
            $user = auth()->user();
            if (auth()->user()->role['name'] == 'Super Admin') {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_queue')
                    ->where('sales_type', 'retailler')
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_queue')
                    ->where('branch_id', $user->branch_id)
                    ->where('sales_type', 'retailler')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        } elseif ($sale_type == 'wholeseller') {
            $user = auth()->user();
            if (auth()->user()->role['name'] == 'Super Admin') {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_queue')
                    ->where('sales_type', 'wholeseller')
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_queue')
                    ->where('branch_id', $user->branch_id)
                    ->where('sales_type', 'wholeseller')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        } else {
            $user = auth()->user();
            if (auth()->user()->role['name'] == 'Super Admin') {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_queue')
                    ->where('sales_type', 'classic_customer')
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_queue')
                    ->where('branch_id', $user->branch_id)
                    ->where('sales_type', 'classic_customer')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }
        $saleType = ucfirst($sale_type);

        return view('lead::installation.queue', compact('customers', 'saleType'));
    }
    public function installationReport($sale_type)
    {
        $user = auth()->user();
        $saleType = ucfirst($sale_type);
        if ($sale_type == 'retailler') {
            if (auth()->user()->role['name'] == 'Super Admin') {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_report')
                    ->where('sales_type', 'retailler')
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_report')
                    ->where('sales_type', 'retailler')
                    ->where('branch_id', $user->branch_id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        } elseif ($sale_type == 'wholeseller') {
            if (auth()->user()->role['name'] == 'Super Admin') {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_report')
                    ->where('sales_type', 'wholeseller')
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_report')
                    ->where('sales_type', 'wholeseller')
                    ->where('branch_id', $user->branch_id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }else{
            if (auth()->user()->role['name'] == 'Super Admin') {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_report')
                    ->where('sales_type', 'classic_customer')
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_report')
                    ->where('sales_type', 'classic_customer')
                    ->where('branch_id', $user->branch_id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }
        return view('lead::installation.reports', compact('customers', 'saleType'));
    }
    public function installationComplete($sale_type)
    {
        $user = auth()->user();
        $saleType = ucfirst($sale_type);
        if ($sale_type == 'retailler') {
            if (auth()->user()->role['name'] == 'Super Admin') {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_complete')
                    ->where('sales_type', 'retailler')
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_complete')
                    ->where('sales_type', 'retailler')
                    ->where('branch_id', $user->branch_id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        } elseif ($sale_type == 'wholeseller') {
            if (auth()->user()->role['name'] == 'Super Admin') {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_complete')
                    ->where('sales_type', 'wholeseller')
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_complete')
                    ->where('sales_type', 'wholeseller')
                    ->where('branch_id', $user->branch_id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }else{
            if (auth()->user()->role['name'] == 'Super Admin') {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_complete')
                    ->where('sales_type', 'classic_customer')
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $customers = Customer::with('lead')
                    ->where('status', 'installation_complete')
                    ->where('sales_type', 'classic_customer')
                    ->where('branch_id', $user->branch_id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }
        return view('lead::installation.complete', compact('customers', 'saleType'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $customer = Customer::with('lead')->findOrfail($id);
        $leadby = User::select('name', 'id')->where('id', $customer->lead['created_by'])->first();
        $staffs = User::where('branch_id', $customer['branch_id'])->get();
        $customerMachines = CustomerProduct::where('customer_id', $customer['id'])->with('product')->get();
        $customerAccessories = CustomerAccessory::where('customer_id', $customer['id'])->with('accessory')->get();
        return view('lead::installation.create', compact('customer', 'customerMachines', 'customerAccessories', 'staffs', 'leadby'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        // Check if the customer already exists
        $customer = Customer::where('lead_id', $request->lead_id)->first();
        $lead = Lead::findOrFail($request->lead_id);

        // Handle Products
        if ($request->has('products_id') && is_array($request->products_id)) {
            foreach ($request->products_id as $index => $productId) {
                if ($productId) {
                    $customerProduct = CustomerProduct::where('customer_id', $customer->id)
                        ->where('product_id', $productId)
                        ->first();

                    if ($customerProduct) {
                        // Update existing product
                        $customerProduct->update([
                            'product_price' => $request->products_price[$index] ?? 0,
                            'product_qty' => $customerProduct->product_qty + ($request->products_qty[$index] ?? 0),
                            'product_total' => ($customerProduct->product_qty + ($request->products_qty[$index] ?? 0)) * ($request->products_price[$index] ?? 0),
                        ]);
                    } else {
                        // Create new product entry
                        CustomerProduct::create([
                            'lead_id' => $request->lead_id,
                            'branch_id' => $lead->branch_id,
                            'customer_id' => $customer->id,
                            'created_by' => auth()->user()->id,
                            'product_id' => $productId,
                            'remarks' => $request->remarks,
                            'product_price' => $request->products_price[$index] ?? 0,
                            'product_qty' => $request->products_qty[$index] ?? 0,
                            'product_total' => $request->products_total[$index] ?? 0,
                            'status' => 'installation_queue',
                        ]);
                    }
                }
            }
        }

        // Update Lead Information
        $lead->update($request->only(['name', 'mobile', 'email', 'address']) + ['status' => 'convert']);

        // Handle Accessories
        if ($request->has('accessories_id') && is_array($request->accessories_id)) {
            foreach ($request->accessories_id as $index => $accessoryId) {
                if ($accessoryId) {
                    $customerAccessory = CustomerAccessory::where('customer_id', $customer->id)
                        ->where('accessory_id', $accessoryId)
                        ->first();

                    if ($customerAccessory) {
                        // Update existing accessory
                        $customerAccessory->update([
                            'accessory_price' => $request->accessories_price[$index] ?? 0,
                            'accessory_qty' => $customerAccessory->accessory_qty + ($request->accessories_qty[$index] ?? 0),
                            'accessory_total' => ($customerAccessory->accessory_qty + ($request->accessories_qty[$index] ?? 0)) * ($request->accessories_price[$index] ?? 0),
                        ]);
                    } else {
                        // Create new accessory entry
                        CustomerAccessory::create([
                            'customer_id' => $customer->id,
                            'lead_id' => $lead->id,
                            'created_by' => auth()->user()->id,
                            'branch_id' => $lead->branch_id,
                            'accessory_id' => $accessoryId,
                            'accessory_qty' => $request->accessories_qty[$index] ?? 0,
                            'accessory_price' => $request->accessories_price[$index] ?? 0,
                            'accessory_total' => $request->accessories_total[$index] ?? 0,
                        ]);
                    }
                }
            }
        }
        // Update new customer
        if ($request->grand_total == $request->paid_amount) {
            $status = 'installation_compltete';
        } else {
            $status = 'installation_report';
        }
        $customer->update([
            'lead_id' => $request->lead_id,
            'converted_by' => $request->converted_by,
            'install_date' => $request->install_date,
            'branch_id' => $lead->branch_id,
            'created_by' => auth()->user()->id,
            'total_amount' => $request->grand_total,
            'due_amount' => $request->grand_total - $request->paid_amount,
            'paid_amount' => $request->paid_amount,
            'customer_type' => 'indoor',
            'status' => $status,
        ]);
        $customerPayment = CustomerPayment::create([
            'created_by' => auth()->user()->id,
            'branch_id' => $lead->branch_id,
            'lead_id' => $request->lead_id,
            'paid_amount' => $request->paid_amount,
            'cutsomer_id' => $customer->id,
            'payment_method' => $request['method'],
        ]);
        return redirect()->route('installation-queue.index', ['sale_type' => $lead->sales_type])->with('success', 'Customer added successfully');
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        dd('m,smdn');
        return view('lead::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('lead::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
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
    public function customerPaymentDetails($id)
    {
        $customer = Customer::where('id',$id)->with('lead','payments')->first();
        return view('lead::installation.payment',compact('customer'));
    }
    public function customerDetails($id)
    {
        $customer = Customer::where('id',$id)->with('lead','products','accessories')->first();
        // dd($customer);
        return view('lead::installation.customer_details',compact('customer'));
    }
}
