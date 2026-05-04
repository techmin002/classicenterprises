<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Lead\Entities\Customer;
use Modules\Lead\Entities\CustomerPayment;
use Modules\SupportDashboard\Entities\CustomerTicket;

class FirstBillController extends Controller
{
 
  public function index()
    {
        // ✅ Unpaid installation customers
        $customers = Customer::with('lead')
            ->where('due_amount', '>', 0)
            ->latest()
            ->get();

        // ✅ Unpaid tickets
        $tickets = CustomerTicket::with('customer.lead')
            ->where('due_amount', '>', 0)
            ->where('status', 'complete')
            ->latest()
            ->get();

        return view('finance::firstbill.index', compact('customers', 'tickets'));
    }

   
}
