<?php

namespace Modules\SupportDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\AMC\Entities\AmcAccessory;
use Modules\AMC\Entities\AmcAssign;
use Modules\AMC\Entities\AmcAssignAccessory;
use Modules\Finance\Entities\PaymentVerification;
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
            'amc'             => $request->amc ?? null,
            'warranty'        => $request->warranty ?? null,
            'assign_to'       => $request->assign_to ?? null,
            'payment_method'  => $request->payment_method ?? null,
            'service_charge'  => 0,
            'amount'          => 0,
            'paid_amount'     => 0,
            'message'         => $request->message ?? '',
            'status'          => 'create',
            'created_by'      => auth()->user()->id ?? null,
        ]);

        return redirect()->route('supportdashboard-task.queue')->with('success', 'Support Ticket Created Successfully.');
    }


    /**
     * Show the specified resource.
     */
    public function show()
    {
        $data = Task::with(['customer.lead', 'customer.products', 'customer.branch'])
            ->where('status', 'create')
            ->get();

        // All users grouped by branch_id
        $users = User::all()->groupBy('branch_id');
        // dd($users);
        return view('supportdashboard::queue.index', compact('data', 'users'));
    }


    public function assign()
    {
        $data = Task::with('customer.lead', 'customer.products')->where('status', 'assign')->get();
        $accessories = Accessory::all();

        $amcMap = [];

        // Group all accessories assigned via AMC by customer
        $assignAccessories = AmcAssignAccessory::with('accessory')->get();

        foreach ($assignAccessories as $item) {
            $customerId = $item->customer_id;
            $accessoryName = $item->accessory->name ?? null;

            if (!$accessoryName) continue;

            $assignedQty = $item->quantity ?? 0;

            // calculate already used quantity (from same table if you store used qty separately or in another table)
            $usedQty = $item->used_quantity ?? 0; // ❗ if no such column, change accordingly

            $remainingQty = max(0, $assignedQty - $usedQty);

            // map result
            if (!isset($amcMap[$customerId])) {
                $amcMap[$customerId] = [];
            }

            // if same accessory assigned multiple times to same customer, add
            if (isset($amcMap[$customerId][$accessoryName])) {
                $amcMap[$customerId][$accessoryName] += $remainingQty;
            } else {
                $amcMap[$customerId][$accessoryName] = $remainingQty;
            }
        }

        return view('supportdashboard::assign.index', compact('data', 'accessories', 'amcMap'));
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
                'customer_id'       => $data->customer_id ?? null,
                'lead_id'           => $data->customer->lead_id ?? null,
                'branch_id'         => $data->customer->branch_id ?? null,
                'total_amount'      => $request->total_amount ?? 0,
                'paid_amount'       => $request->paid_amount ?? 0,
                'remaining_amount'  => ($request->total_amount ?? 0) - ($request->paid_amount ?? 0),
                'payment_method'    => $request->paymentTaken === 'yes' ? $request->payment_method : null,
                'payment_date'      => now(),
                'status'            => 'on',
                'message'           => $request->message ?? null,
                'receipt'           => null,
                'created_by'        => auth()->user()->name,
            ];
            PaymentVerification::create($verificationData);
        }

        // Store accessories and update AMC accessory quantities

        if ($request->has('accessories')) {
            $customerId = $request->customer_id;

            // Get the AMC assignment for this customer
            $amcAssign = AmcAssign::where('customer_id', $customerId)->first();

            if ($amcAssign) {
                foreach ($request->accessories as $item) {
                    $accessoryId = $item['accessory_id'] ?? null;
                    $usedQty = $item['qty'] ?? 0;

                    if ($accessoryId && $usedQty > 0) {
                        // Get the accessory from amc_assign_accessories instead of amc_accessories
                        $assignAccessory = AmcAssignAccessory::where('amc_assign_id', $amcAssign->id)
                            ->where('accessory_id', $accessoryId)
                            ->first();

                        if ($assignAccessory) {
                            // Reduce quantity
                            $updatedQty = max(0, $assignAccessory->quantity - $usedQty);
                            $assignAccessory->update(['quantity' => $updatedQty]);
                        }
                    }
                }
            }
        }

        // dd('exit');

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
