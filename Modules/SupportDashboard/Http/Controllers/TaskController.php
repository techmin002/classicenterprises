<?php

namespace Modules\SupportDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Lead\Entities\Customer;
use Modules\Product\Entities\Accessory;
use Modules\SupportDashboard\Entities\Task;

class TaskController extends Controller
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
        $customers = Customer::where('customer_type', 'indoor')->with('lead', 'branch', 'products')->get();
        return view('supportdashboard::supports.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        Task::create([
            'customer_id'     => $request->customer_id,
            'support_type'    => $request->support_type,
            'priority'        => $request->priority,
            'assign_to'       => $request->assign_to ?? null, // store only if present
            'payment_method'  => $request->payment_method ?? null,
            'service_charge'  => 0,
            'amount'          => 0,
            'paid_amount'     => 0,
            'message'         => $request->message ?? '',
            'status'          => 'create',
            'created_by'      => auth()->user()->id ?? null,
        ]);

        // return redirect()->back()->with('success', 'Support Ticket Created Successfully');
        return redirect()->route('supportdashboard-task.queue')->with('success', 'Support Ticket Created Successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show()
    {
        $data = Task::with('customer.lead', 'customer.products')->get();
        return view('supportdashboard::queue.index', compact('data'));
    }

    public function assign()
    {

        $data = Task::with('customer.lead', 'customer.products')
            ->where('status', 'assign')
            ->get();
        $accessories = Accessory::all();

        return view('supportdashboard::assign.index', compact('data', 'accessories'));
    }
    public function complete()
    {
        $data = Task::with('customer.lead', 'customer.products', 'serviceItems') // include serviceItems
            ->where('status', 'complete')
            ->get();

        return view('supportdashboard::complete.index', compact('data'));
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
        $task = Task::findOrFail($id);

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

            return redirect()->route('supportdashboard-task.assign')->with('success', 'Task updated successfully.');
        }

        return redirect()->back()->with('error', 'Invalid action type.');
    }

    public function completestore(Request $request, $id)
    {

        $data = Task::findOrFail($id);
        // dd($request->all()); // confirm all inputs are received correctly

        $data->service_type =  $request->input('service_type');
        $data->service_charge = $request->service_method === 'paid' ? ($request->service_charge ?? 0) : 'free';
        $data->payment_method = $request->paymentTaken === 'yes' ? $request->payment_method : null;
        $data->paid_amount = $request->paymentTaken === 'yes' ? ($request->paid_amount ?? 0) : 0;
        $data->message = $request->message ?? null;
        $data->amount = $request->total_amount ?? null;
        $data->status = 'complete';
        $data->save();


        // Store accessories
        if ($request->has('accessories')) {
            foreach ($request->accessories as $accessory) {
                DB::table('task_service_items')->insert([
                    'task_id' => $data->id,
                    'name' => $accessory['name'],
                    'qty' => $accessory['qty'],
                    'price' => $accessory['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('supportdashboard-task.complete')->with('success', 'Task Completed');
    }
    public function completeDetails($id)
    {
        $task = Task::with('customer.lead', 'customer.products', 'serviceItems')
            ->findOrFail($id);

        // Service items total (only for this task_id)
        $itemsTotal = $task->serviceItems->sum(function ($item) {
            return $item->qty * $item->price;
        });

        // Grand total = service charge + items total
        $grandTotal = ($task->service_charge ?? 0) + $itemsTotal;

        return view('supportdashboard::complete.viewdetails', compact('task', 'grandTotal'));
    }
}
