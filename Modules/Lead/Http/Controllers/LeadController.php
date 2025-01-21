<?php

namespace Modules\Lead\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Employee\Entities\Employee;
use Modules\Lead\Entities\Lead;
use Modules\Branch\Entities\Branch;
use Modules\Lead\Entities\Customer;
use Modules\Lead\Entities\CustomerAccessory;
use Modules\Lead\Entities\CustomerProduct;
use Modules\Lead\Entities\LeadResponse;
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

        // dd($request->all());
        $lead = new Lead();
        $lead->name = $request->input('name') ?? 'N/A';
        $lead->email = $request->input('email') ?? NULL;
        $lead->address = $request->input('address') ?? 'N/A';
        $lead->mobile = $request->input('mobile');
        $lead->landline = $request->input('landline') ?? NULL;
        $lead->lead_type = $request->input('type');
        $lead->branch_id = $branch_id ?? NULL;
        $lead->created_by = auth()->user()->id;
        $lead->message = $request->input('message');
        $lead->followups = $formattedDate;
        $lead->save();
        $res = LeadResponse::create([
            'lead_id' => $lead->id,
            'branch_id' => $lead->branch_id,
            'created_by' => $lead->created_by,
            'message' => $request->input('message'),
            'followups' => $formattedDate
        ]);
        return back()->with('success', 'Lead added successfully');
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
        $lead = Lead::findOrfail($id);
        $lead->name = $request->input('name');
        $lead->email = $request->input('email');
        $lead->address = $request->input('address');
        $lead->mobile = $request->input('mobile');
        $lead->message = $request->input('message');
        $lead->save();

        return back()->with('success', 'Lead Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $lead = Lead::findOrfail($id);
        if ($lead) {
            $lead->update([
                'deleted_at' => Carbon::now(),
            ]);
            return back()->with('success', 'Lead Updated successfully');
        } else {
            return back()->with('error', 'Lead Not Found');
        }
    }
    public function hotLeads()
    {

        $branches = Branch::all();
        if(auth()->user()->role['name'] === 'Super Admin'){
            $leads = Lead::with('responses', 'branch')->where('lead_type', 'hot')->get();

        }else{
            $branch_id = auth()->user()->branch_id;
            $leads = Lead::with('responses', 'branch')->where('branch_id',$branch_id)->where('lead_type', 'hot')->get();
        }
        $type = 'hot';
        return view('lead::leads.index', compact('leads', 'type', 'branches'));
    }
    public function warmLeads()
    {

        $branches = Branch::all();
        if(auth()->user()->role['name'] === 'Super Admin'){
            $leads = Lead::with('responses', 'branch')->where('lead_type', 'warm')->get();

        }else{
            $branch_id = auth()->user()->branch_id;
            $leads = Lead::with('responses', 'branch')->where('branch_id',$branch_id)->where('lead_type', 'warm')->get();
        }
        $type = 'warm';
        return view('lead::leads.index', compact('leads', 'type', 'branches'));
    }
    public function coldLeads()
    {

        $branches = Branch::all();
        if(auth()->user()->role['name'] === 'Super Admin'){
            $leads = Lead::with('responses', 'branch')->where('lead_type', 'cold')->get();

        }else{
            $branch_id = auth()->user()->branch_id;
            $leads = Lead::with('responses', 'branch')->where('branch_id',$branch_id)->where('lead_type', 'cold')->get();
        }
        $type = 'cold';
        return view('lead::leads.index', compact('leads', 'type', 'branches'));
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
                    ->where('status','non_convert')
                    ->get();
        return view('lead::response.followups', compact('leads'));
    }
    public function leadToClient($id)
    {
        $lead = Lead::findOrfail($id);
        $branches = Branch::where('status','on')->get();
        $machineries = Machinery::all();
        $accessories = Accessory::all();
        return view('lead::client.create', compact('branches','lead','machineries','accessories'));
    }
    // AccessoryController.php
public function getAccessories(Request $request)
{
    $search = $request->get('search', '');
    $accessories = Accessory::where('name', 'LIKE', "%{$search}%")
        ->select('id', 'name', 'sales_price')
        ->get();

    return response()->json($accessories);
}
public function leadToClientStore(Request $request)
{
    // dd($request->all());
    $request->validate([
        'lead_id' => 'required',
        'name' => 'required|string',
        'email' => 'nullable|email',
        'mobile' => 'required|string',
        'address' => 'required|string',
        'product_id' => 'required',

    ]);

    $customer = Customer::where('lead_id', $request->lead_id)->first();
    $lead = Lead::findOrFail($request->lead_id);
    if ($customer) {
        return back()->with('error', 'Customer Already Exist on Installation Queue');
    }else{
        $customer = Customer::create([
            'lead_id' => $request->lead_id,
            'branch_id' => $lead->branch_id,
            'created_by' => auth()->user()->id,
            'total_amount' => $request->grand_total,
            'customer_type' => 'indor',
            'status' => 'installation_queue',
        ]);
    }
    $customerProduct = CustomerProduct::create([
        'lead_id' => $request->lead_id,
        'branch_id' => $lead->branch_id,
        'customer_id' => $customer->id,
        'created_by' => auth()->user()->id,
        'product_id' => $request->product_id,
        'remarks' => $request->remark,
        'product_price' => $request->backend_price,
        'status' => 'installation_queue',
    ]);
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
    dd('success');
    return redirect(route('customer.index'))->with('success', 'Customer added successfully');
}



}
