<?php

namespace Modules\OutSiderSupportDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Branch\Entities\Branch;
use Modules\Finance\Entities\PaymentVerification;
use Modules\Lead\Entities\Customer;
use Modules\OutSiderSupportDashboard\Entities\OutSideTask;
use Modules\Product\Entities\Accessory;

class OutSideTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = OutSideTask::where('status', 'create')->get();
        $branches = Branch::all();
        $users = User::all()->groupBy('branch_id');
        return view('outsidersupportdashboard::supports.index', compact('branches', 'data', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // dd($request->only(['address', 'home_address']));
        OutSideTask::create([
            'name'         => $request->name,
            'product'      => $request->product,
            'email'        => $request->email,
            'contact'      => $request->contact,
            'date'      => $request->date,
            'branch_id'    => $request->branch_id,
            'customer_id'     => $request->customer_id ?? null,
            'support_type'    => $request->support_type,
            'priority'        => $request->priority,
            'address'        => $request->address,
            'home_address'        => $request->home_address,
            'assign_to'       => $request->assign_to ?? null, // store only if present
            'payment_method'  => $request->payment_method ?? null,
            'service_charge'  => 0,
            'amount'          => 0,
            'paid_amount'     => 0,
            'message'         => $request->message ?? '',
            'status'          => 'create',
            'created_by'      => auth()->user()->id ?? null,
        ]);

        return redirect()->back()->with('success', 'Support Ticket Created Successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show() {}


    public function assign()
    {

        $data = OutSideTask::with('customer.lead', 'customer.products')
            ->where('status', 'assign')
            ->get();
        $accessories = Accessory::all();

        return view('outsidersupportdashboard::assign.index', compact('data', 'accessories'));
    }
    public function complete()
    {
        $data = OutSideTask::with('customer.lead', 'customer.products', 'outer_service_items') // include serviceItems
            ->where('status', 'complete')
            ->get();

        return view('outsidersupportdashboard::complete.index', compact('data'));
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
    public function queue()
    {
        return view('supportdashboard::queue.index');
    }


    public function assignstore(Request $request, $id)
    {
        $task = OutSideTask::findOrFail($id);

        // dd($request->all()); // confirm all inputs are received correctly

        if ($request->action_type === 'comment') {
            $task->update([
                'message' => $request->message,
            ]);

            return redirect()->back()->with('success', 'Message updated successfully.');
        }

        if ($request->action_type === 'assign') {
            $task->assign_to = $request->assign_to;
            $task->message = $request->message;
            $task->status = 'assign';
            $task->save(); // Make sure this line is present

            return redirect()->route('outsidersupportdashboard-task.assign')->with('success', 'Task updated successfully.');
        }

        return redirect()->back()->with('error', 'Invalid action type.');
    }

    public function completestore(Request $request, $id)
    {

        // dd($request->all());
        $data = OutSideTask::findOrFail($id);
        // dd($request->all()); // confirm all inputs are received correctly

        $data->service_type =  $request->input('service_type');
        $data->service_charge = $request->service_method === 'paid' ? ($request->service_charge ?? 0) : 0;
        $data->payment_method = $request->paymentTaken === 'yes' ? $request->payment_method : null;
        $data->paid_amount = $request->paymentTaken === 'yes' ? ($request->paid_amount ?? 0) : 0;
        $data->message = $request->message ?? null;
        $data->amount = $request->total_amount ?? null;
        $data->status = 'complete';
        $data->save();


        // ✅ Insert into PaymentVerification
        if ($request->service_method === 'paid') {
            $verificationData = [
                'customer_id'       => $data->customer_id ?? $data->id,
                'lead_id'           => $data->customer->lead_id ?? null,
                'branch_id'         => $data->branch_id ?? null,
                'total_amount'      => $request->total_amount ?? 0,
                'paid_amount'       => $request->paid_amount ?? 0,
                'remaining_amount'  => ($request->total_amount ?? 0) - ($request->paid_amount ?? 0),
                'payment_method'    => $request->paymentTaken === 'yes' ? $request->payment_method : null,
                'payment_date'      => now(),
                'status'            => 'on',
                'message'           => $request->message ?? null,
                'receipt'           => null,
                'customer_type'     => 'outsider',
                'created_by'        => auth()->user()->name,
            ];
            PaymentVerification::create($verificationData);
        }

        // Store accessories
        if ($request->has('accessories')) {
            foreach ($request->accessories as $accessory) {
                DB::table('outer_service_items')->insert([
                    'task_id' => $data->id,
                    'name' => $accessory['name'],
                    'qty' => $accessory['qty'],
                    'price' => $accessory['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }



        return redirect()->route('outsidersupportdashboard-task.complete')->with('success', 'Task Completed');
    }
    public function completeDetails($id)
    {
        $task = OutSideTask::with('customer.lead', 'customer.products', 'outer_service_items')
            ->findOrFail($id);

        // Service items total (only for this task_id)
        $itemsTotal = $task->outer_service_items->sum(function ($item) {
            return $item->qty * $item->price;
        });

        // Grand total = service charge + items total
        $grandTotal = ($task->service_charge ?? 0) + $itemsTotal;

        return view('outsidersupportdashboard::complete.viewdetails', compact('task', 'grandTotal'));
    }
}
