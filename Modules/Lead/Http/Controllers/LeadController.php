<?php

namespace Modules\Lead\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Employee\Entities\Employee;
use Modules\Lead\Entities\Lead;
use Modules\Branch\Entities\Branch;
use Modules\Lead\Entities\Customer;
use Modules\Lead\Entities\CustomerAccessory;
use Modules\Lead\Entities\CustomerNote;
use Modules\Lead\Entities\CustomerProduct;
use Modules\Lead\Entities\Exchange;
use Modules\Lead\Entities\LeadResponse;
use Modules\Lead\Entities\Skim;
use Modules\Product\Entities\Accessory;
use Modules\Product\Entities\Machinery;
use Modules\Product\Entities\Product;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('lead::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('lead::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd(session('branch_id'));

        // dd('hello');
        try {
            $emp = Employee::where('user_id', auth()->user()->id)->select('id', 'branch_id')->first();

            if ($request->branch_id) {
                $branch_id = $request->branch_id;
            } else {
                if ($emp) {
                    $branch_id = $emp->branch_id;
                } else {
                    $branch_id = null;
                }
            }
            $formattedDate = Carbon::createFromFormat('m/d/Y h:i A', $request->input('date_time'))->format('Y-m-d H:i:s');
            if ($request->input('lead_source') == 'staff') {
                $staff_id = $request->input('staff_id');
            }
            // dd($request->input('type'));
            $lead = new Lead();
            $lead->name = $request->input('name');
            $lead->lead_source = $request->input('lead_source');
            $lead->staff_id = $staff_id ?? NULL;
            $lead->sales_type = $request->input('sales_type');
            $lead->email = $request->input('email') ?? NULL;
            $lead->address = $request->input('address');
            $lead->mobile = $request->input('mobile');
            $lead->landline = $request->input('landline') ?? NULL;
            $lead->lead_type = $request->input('type');
            $lead->installation_category = $request->input('installation_category');
            $lead->branch_id = session('branch_id');
            $lead->created_by = auth()->user()->id;
            $lead->message = $request->input('message');
            $lead->followups = $formattedDate;

            if ($request->lead_source === 'staff') {
                $lead->staff_id = $request->input('staff_id');
                $lead->is_refere = 'staff';
                $lead->refer_by = null;
                $lead->refer_contact = null;
            } elseif ($request->lead_source === 'customer') {
                $customerType = $request->input('customer_type');

                if ($customerType === 'register') {
                    $lead->staff_id = null;
                    $lead->is_refere = 'customer';
                    $lead->refer_by = $request->input('customer_id'); // store customer id
                    $lead->refer_contact = null;
                } elseif ($customerType === 'not_register') {
                    $lead->staff_id = null;
                    $lead->is_refere = 'manual';
                    $lead->refer_by = $request->input('manual_customer_name'); // manual name
                    $lead->refer_contact = $request->input('manual_customer_mobile'); // manual mobile
                }
            }

            $lead->save();
            $res = LeadResponse::create([
                'lead_id' => $lead->id,
                'branch_id' => $lead->branch_id,
                'created_by' => $lead->created_by,
                'message' => $request->input('message'),
                'followups' => $formattedDate
            ]);

            Log::create([
                'perform'   => auth()->user()->name . ' created. ' . $request->input('type') . ' lead: '
                    . $lead->name . ' at ' . now(),
                'user_id'   => auth()->user()->id,
                'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
                'url'       => url()->current(),
            ]);
            CustomerNote::create([
                'lead_id' => $lead->id,
                'note' => $request->input('message'),
            ]);
            return back()->with('success', 'Lead added successfully');
        } catch (QueryException $e) {
            // Check for duplicate entry error (1062)
            if ($e->getCode() == 23000) {
                return back()->with('error', 'Mobile number or email already exists!');
            }
            // Any other database error
            return back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $lead = Lead::with('responses', 'employee')->where('id', $id)->first();
        // dd($lead);
        $branches = Branch::all();
        return view('lead::response.index', compact('lead', 'branches'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('lead::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        // dd($request->all());
        try {
            $formattedDate = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('date_time'))->format('Y-m-d H:i:s');
            if ($request->input('lead_source') == 'staff') {
                $staff_id = $request->input('staff_id');
            }
            // dd($request->input('type'));
            $lead = Lead::findOrfail($id);
            $lead->name = $request->input('name');
            $lead->lead_source = $request->input('lead_source');
            $lead->staff_id = $staff_id ?? NULL;
            $lead->sales_type = $request->input('sales_type');
            $lead->email = $request->input('email') ?? NULL;
            $lead->address = $request->input('address');
            $lead->mobile = $request->input('mobile');
            $lead->landline = $request->input('landline') ?? NULL;
            $lead->installation_category = $request->input('installation_category');
            $lead->message = $request->input('message');
            $lead->followups = $formattedDate;

            if ($request->lead_source === 'staff') {
                $lead->staff_id = $request->input('staff_id');
                $lead->is_refere = 'staff';
                $lead->refer_by = null;
                $lead->refer_contact = null;
            } elseif ($request->lead_source === 'customer') {
                $customerType = $request->input('customer_type');

                if ($customerType === 'register') {
                    $lead->staff_id = null;
                    $lead->is_refere = 'customer';
                    $lead->refer_by = $request->input('customer_id'); // store customer id
                    $lead->refer_contact = null;
                } elseif ($customerType === 'not_register') {
                    $lead->staff_id = null;
                    $lead->is_refere = 'manual';
                    $lead->refer_by = $request->input('manual_customer_name'); // manual name
                    $lead->refer_contact = $request->input('manual_customer_mobile'); // manual mobile
                }
            }

            $lead->save();

            $leadResponse = LeadResponse::where('lead_id', $lead->id)->first();
            $leadResponse->update([
                'message'    => $request->input('message'),
                'followups'  => $formattedDate,
            ]);
            Log::create([
                'perform'   => auth()->user()->name . ' Update. ' . $request->input('type') . ' lead: '
                    . $lead->name . ' at ' . now(),
                'user_id'   => auth()->user()->id,
                'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
                'url'       => url()->current(),
            ]);
            CustomerNote::create([
                'lead_id' => $lead->id,
                'note' => $request->input('message'),
            ]);
            return back()->with('success', 'Lead added successfully');
        } catch (QueryException $e) {
            // Check for duplicate entry error (1062)
            // if ($e->getCode() == 23000) {
            //     return back()->with('error', 'Mobile number or email already exists!');
            // }
            // Any other database error
            return back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        // dd('hii');
        $lead = Lead::findOrfail($id);
        if ($lead) {
            $lead->update([
                'deleted_at' => Carbon::now(),
            ]);
            return back()->with('success', 'Lead Updated successfully');
        } else {
            return back()->with('error', 'Lead Not Found');
        }
        Log::create([
            'perform'   => auth()->user()->name . ' Deleted. ' . $lead->lead_type . ' lead: '
                . $lead->name . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
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





    public function hotLeads(Request $request)
    {
        $branches = Branch::all();

        // Start query (no get() yet)
        if (auth()->user()->role['name'] === 'Super Admin') {
            $leads = Lead::with('responses', 'branch')
                ->where('branch_id', session('branch_id')) // as you had it
                ->where('status', 'non_convert')
                ->where('lead_type', 'hot');
        } else {
            $branch_id = auth()->user()->branch_id;
            $leads = Lead::with('responses', 'branch')
                ->where('branch_id', session('branch_id'))
                ->where('status', 'non_convert')
                ->where('branch_id', $branch_id)
                ->where('lead_type', 'hot');
        }

        // ✅ Predefined filters
        if ($request->filter == '7days') {
            $leads->where('created_at', '>=', now()->subDays(7));
        } elseif ($request->filter == '15days') {
            $leads->where('created_at', '>=', now()->subDays(15));
        } elseif ($request->filter == '1month') {
            $leads->where('created_at', '>=', now()->subMonth());
        }

        // ✅ Custom date filter
        if ($request->filled(['start_date', 'end_date'])) {
            $start = $request->start_date . ' 00:00:00';
            $end = $request->end_date . ' 23:59:59';
            $leads->whereBetween('created_at', [$start, $end]);
        }

        // ✅ Always order latest first
        $leads = $leads->orderBy('created_at', 'desc')->get();

        foreach ($leads as $lead) {
            $lead->created_time = $this->formatTimeDifference($lead->created_at);
        }

        $type = 'hot';
        $leadtype = 'hot-leads';
        return view('lead::leads.index', compact('leads', 'type', 'branches', 'leadtype'));
    }

    public function warmLeads(Request $request)
    {
        // dd('hello');
        $branches = Branch::all();

        // Start query (no get() yet)
        if (auth()->user()->role['name'] === 'Super Admin') {
            $leads = Lead::with('responses', 'branch')
                ->where('branch_id', session('branch_id')) // as you had it
                ->where('status', 'non_convert')
                ->where('lead_type', 'warm');
        } else {
            $branch_id = auth()->user()->branch_id;
            $leads = Lead::with('responses', 'branch')
                ->where('branch_id', session('branch_id'))
                ->where('status', 'non_convert')
                ->where('branch_id', $branch_id)
                ->where('lead_type', 'warm');
        }

        // ✅ Predefined filters
        if ($request->filter == '7days') {
            $leads->where('created_at', '>=', now()->subDays(7));
        } elseif ($request->filter == '15days') {
            $leads->where('created_at', '>=', now()->subDays(15));
        } elseif ($request->filter == '1month') {
            $leads->where('created_at', '>=', now()->subMonth());
        }

        // ✅ Custom date filter
        if ($request->filled(['start_date', 'end_date'])) {
            $start = $request->start_date . ' 00:00:00';
            $end = $request->end_date . ' 23:59:59';
            $leads->whereBetween('created_at', [$start, $end]);
        }

        // ✅ Always order latest first
        $leads = $leads->orderBy('created_at', 'desc')->get();

        foreach ($leads as $lead) {
            $lead->created_time = $this->formatTimeDifference($lead->created_at);
        }

        $type = 'warm';
        $leadtype = 'warm-leads';
        return view('lead::leads.index', compact('leads', 'type', 'branches', 'leadtype'));
    }
    public function coldLeads(Request $request)
    {
        $branches = Branch::all();

        // Start query (no get() yet)
        if (auth()->user()->role['name'] === 'Super Admin') {
            $leads = Lead::with('responses', 'branch')
                ->where('branch_id', session('branch_id')) // as you had it
                ->where('status', 'non_convert')
                ->where('lead_type', 'cold');
        } else {
            $branch_id = auth()->user()->branch_id;
            $leads = Lead::with('responses', 'branch')
                ->where('branch_id', session('branch_id'))
                ->where('status', 'non_convert')
                ->where('branch_id', $branch_id)
                ->where('lead_type', 'cold');
        }

        // ✅ Predefined filters
        if ($request->filter == '7days') {
            $leads->where('created_at', '>=', now()->subDays(7));
        } elseif ($request->filter == '15days') {
            $leads->where('created_at', '>=', now()->subDays(15));
        } elseif ($request->filter == '1month') {
            $leads->where('created_at', '>=', now()->subMonth());
        }

        // ✅ Custom date filter
        if ($request->filled(['start_date', 'end_date'])) {
            $start = $request->start_date . ' 00:00:00';
            $end = $request->end_date . ' 23:59:59';
            $leads->whereBetween('created_at', [$start, $end]);
        }

        // ✅ Always order latest first
        $leads = $leads->orderBy('created_at', 'desc')->get();

        foreach ($leads as $lead) {
            $lead->created_time = $this->formatTimeDifference($lead->created_at);
        }

        $type = 'cold';
        $leadtype = 'cold-leads';
        return view('lead::leads.index', compact('leads', 'type', 'branches', 'leadtype'));
    }
    public function responseStore(Request $request)
    {
        // dd($request->all());
        $emp = Employee::where('user_id', auth()->user()->id)->select('id', 'branch_id')->first();
        if ($request->branch_id) {
            $branch_id = $request->branch_id;
        } else {
            if ($emp) {
                $branch_id = $emp->branch_id;
            } else {
                $branch_id = null;
            }
        }
        $formattedDate = Carbon::createFromFormat('m/d/Y h:i A', $request->input('date_time'))->format('Y-m-d H:i:s');

        $lead = Lead::where('id', $request['lead_id'])->first();
        $res = LeadResponse::create([
            'lead_id' => $lead->id,
            'branch_id' => $branch_id,
            'created_by' => auth()->user()->id,
            'message' => $request->input('message'),
            'followups' => $formattedDate
        ]);
        $lead->update([
            'message' => $request->input('message'),
            'followups' => $formattedDate
        ]);
        return back()->with('success', 'Response added successfully');
    }
    public function responseUpdate(Request $request, $id)
    {
        $res = LeadResponse::findOrfail($id)->update([
            'message' => $request->input('message'),
            'followups' => $request['date_time']
        ]);
        return back()->with('success', 'Response added successfully');
    }
    public function responseDelete($id)
    {
        $res = LeadResponse::findOrfail($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return back()->with('success', 'Response added successfully');
    }
    public function followups()
    {
        $now = Carbon::now();
        $futureOneDay = Carbon::now()->addDay();
        // Fetch records where followups are in the past or within the next one day
        $leads = Lead::where('followups', '<=', $futureOneDay)
            ->where('status', 'non_convert')
            ->where('branch_id', session('branch_id'))
            ->get();
        return view('lead::response.followups', compact('leads'));
    }
    public function leadToClient($id)
    {
        $lead = Lead::findOrfail($id);
        $branches = Branch::where('status', 'on')->get();
        $machineries = Machinery::all();
        $accessories = Accessory::all();
        $branch_id = session('branch_id');
        $staffs = User::where('branch_id', $branch_id)->get();
        return view('lead::client.create', compact('branches', 'lead', 'machineries', 'staffs', 'accessories'));
    }
    // AccessoryController.php
    public function getAccessories(Request $request)
    {
        $search = $request->get('search', '');
        $accessories = Accessory::where('name', 'LIKE', "%{$search}%")
            ->select('id', 'name', 'sales_price', 'units')
            ->get();

        return response()->json($accessories);
    }
    public function getProducts(Request $request)
    {
        $search = $request->get('search', '');

        // Fetch products based on the search query
        $products = Machinery::where('name', 'like', "%{$search}%")
            ->select('id', 'name', 'sales_price', 'units') // Include fields needed for the dropdown
            ->limit(10) // Limit results for performance
            ->get();

        // Return JSON response
        return response()->json($products);
    }
    public function leadToClientStore(Request $request)
    {
        // dd(auth()->user()->id);
        // dd($request->all());
        $request->validate([
            'lead_id' => 'required',
            'name' => 'required|string',
            'email' => 'nullable|email',
            'mobile' => 'required|string',
            'address' => 'required|string',
        ]);

        $customer = Customer::where('lead_id', $request->lead_id)->first();
        $lead = Lead::findOrFail($request->lead_id);
        if ($customer) {
            return back()->with('error', 'Customer Already Exist on Installation Queue');
        } else {
            $customer = Customer::create([
                'lead_id'           => $request->lead_id,
                'branch_id' => $lead->branch_id,
                'created_by' => auth()->user()->id,
                'converted_by'      => $request->converted_by,
                'total_amount' => $request->grand_total,
                'exchange_amount' => $request->total_exchange,
                'due_amount' => $request->grand_total,
                'message' => $request->remark,
                'customer_type' => 'indor',
                'sales_type' => $lead->sales_type,
                'installation_category' => $lead->installation_category,
                'status' => 'installation_queue',
            ]);
        }
        if ($request->has('products_id') && is_array($request->products_id)) {
            foreach ($request->products_id as $index => $productId) {

                if ($productId) {
                    $customerProduct = CustomerProduct::create([
                        'lead_id' => $request->lead_id,
                        'branch_id' => $lead->branch_id,
                        'customer_id' => $customer->id,
                        'created_by' => auth()->user()->id,
                        'product_id' => $productId,
                        'remarks' => $request->remark,
                        'product_price' => $request->products_price[$index] ?? 0,
                        'product_qty' => $request->products_qty[$index] ?? 0,
                        'product_total' => $request->products_total[$index] ?? 0,
                        'exchange'         => $request->is_exchange ?? 'no',
                        'total_exchange'   => $request->total_exchange ?? 0,
                        'status' => 'installation_queue',
                    ]);
                }
            }
        }
        $lead->update($request->only(['name', 'mobile', 'email', 'address']) + ['status' => 'convert']);

        if ($request->has('accessories_id') && is_array($request->accessories_id)) {
            foreach ($request->accessories_id as $index => $accessoryId) {

                if ($accessoryId) {
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
        if ($request->is_exchange === 'yes' && $request->has('exchange_names')) {
            foreach ($request->exchange_names as $index => $name) {
                Exchange::create([
                    'lead_id' => $lead->id,
                    'branch_id' => $lead->branch_id,
                    'customer_id' => $customer->id,
                    'item_name'   => $name,
                    'item_amount' => $request->exchange_prices[$index] ?? 0,
                ]);
            }
        }

        if ($request->is_skim === 'yes' && $request->has('skim_item_name')) {
            foreach ($request->skim_item_name as $index => $name) {
                Skim::create([
                    'lead_id' => $lead->id,
                    'branch_id' => $lead->branch_id,
                    'customer_id' => $customer->id,
                    'skim_item_name'   => $name,
                ]);
            }
        }

        Log::create([
            'perform'   => auth()->user()->name . ' Convert Lead to Client: '
                . $lead->name . '-' . $lead->lead_type . ' Lead -' . ($lead->sales_type) . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        CustomerNote::create([
            'lead_id' => $lead->id,
            'customer_id' => $customer->id,
            'note' => $request->remark,
        ]);
        if ($lead->sales_type) {
            // Redirect to sales type route
            return redirect()->route('installation-queue.index', ['sale_type' => $lead->sales_type])
                ->with('success', 'Customer added successfully');
        } else {
            // Redirect to installation category route
            return redirect()->route('installation-category-queue.index', ['installation_category' => $lead->installation_category])
                ->with('success', 'Customer added successfully');
        }
    }
    public function retailler()
    {
        $branches = Branch::all();
        if (auth()->user()->role['name'] === 'Super Admin') {
            $leads = Lead::with('responses', 'branch')->where('branch_id', session('branch_id'))->where('status', 'non_convert')->where('sales_type', 'retailler')->get();
        } else {
            $branch_id = auth()->user()->branch_id;
            $leads = Lead::with('responses', 'branch')->where('branch_id', session('branch_id'))->where('status', 'non_convert')->where('branch_id', $branch_id)->where('sales_type', 'retailler')->get();
        }
        $type = 'Retailler';
        return view('lead::leads.index', compact('leads', 'type', 'branches'));
    }
    public function wholeseller()
    {
        $branches = Branch::all();
        if (auth()->user()->role['name'] === 'Super Admin') {
            $leads = Lead::with('responses', 'branch')->where('branch_id', session('branch_id'))->where('status', 'non_convert')->where('sales_type', 'wholeseller')->get();
        } else {
            $branch_id = auth()->user()->branch_id;
            $leads = Lead::with('responses', 'branch')->where('branch_id', session('branch_id'))->where('status', 'non_convert')->where('branch_id', $branch_id)->where('sales_type', 'wholeseller')->get();
        }
        $type = 'Wholeseller';
        return view('lead::leads.index', compact('leads', 'type', 'branches'));
    }
    public function getStaff()
    {
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branchId = session('branch_id');
        } else {
            $branchId = auth()->user()->branch_id;
        }
        $staff = User::where('branch_id', $branchId)->select('id', 'name')->get();

        return response()->json($staff);
    }
    public function getCustomer()
    {
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branchId = session('branch_id');
        } else {
            $branchId = auth()->user()->branch_id;
        }

        // Eager load 'lead' relationship
        $customers = Customer::with('lead')
            ->where('branch_id', $branchId)
            ->get();

        // Map to JSON-friendly array with lead name
        $data = $customers->map(function ($customer) {
            return [
                'id' => $customer->id,
                'name' => optional($customer->lead)->name, // fetch from Lead table
                'mobile' => optional($customer->lead)->mobile ?? '', // if you want lead mobile
            ];
        });

        return response()->json($data);
    }

    public function leadtransfer(Request $request)
    {
        // dd($request->all());

        $lead = Lead::findOrfail($request->lead_id);

        $lead->branch_id = $request->branch_id;
        // Save the changes
        $lead->save();
        // Optional: redirect back with success message
        return redirect()->back()->with('success', 'Lead transferred successfully.');
    }

    public function LeadDetails($id)
    {
        $lead = Lead::with(['responses', 'branch'])
            ->where('branch_id', session('branch_id'))
            ->where('id', $id)
            ->first();

        if (!$lead) {
            abort(404, 'Lead not found');
        }

        // Add formatted time property for Blade
        $lead->formatted_time = $this->formatTimeDifference($lead->created_at);

        return view('lead::details.leaddetails', compact('lead'));
    }
}
