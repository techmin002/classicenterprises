<?php

namespace Modules\SupportDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Lead\Entities\Customer;
use Modules\SupportDashboard\Entities\CustomerTicket;
use Modules\SupportDashboard\Entities\Task;

class SupportDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role->name === 'Super Admin') {
            // Super Admin → use selected branch from session
            $branchId = session('branch_id');
        } else {
            // Normal user → use logged-in user's branch
            $branchId = auth()->user()->branch_id;
        }

        $totalcustomer = Customer::where('customer_type', 'indoor')->where('branch_id', $branchId)->with('lead', 'branch', 'products')->count();
        $createcount = Task::with(['customer.branch'])
            ->where('status', 'create')
            ->whereHas('customer', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })
            ->count();
        $assigncount = Task::with(['customer.branch'])
            ->where('status', 'assign')
            ->whereHas('customer', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })
            ->count();
        $completecount = Task::with(['customer.branch'])
            ->where('status', 'complete')
            ->whereHas('customer', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })
            ->count();

        return view('supportdashboard::index', compact('totalcustomer', 'createcount', 'assigncount', 'completecount'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

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

    // public function paymentdetails($id)
    // {
    //     $customer = Task::findOrFail($id);
    //     $payment = OutsiderPaymentVerification::where('customer_id', $id)->get();
    //     return view('outsidersupportdashboard::complete.payment', compact('payment', 'customer'));
    // }
}
