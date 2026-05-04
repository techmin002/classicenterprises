<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Finance\Entities\PaymentVerification;
use Modules\Lead\Entities\CustomerPayment;
use Modules\Lead\Entities\Customer;
use Modules\SupportDashboard\Entities\CustomerTicketPayment;
use Modules\SupportDashboard\Entities\CustomerTicket;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $data = PaymentVerification::with([
            'customer:id,lead_id',
            'customer.lead:id,name',
            'lead:id,name',
            'branch:id,name',
        ])->latest()->get();

        return view('finance::paymentverification.index', compact('data'));
    }

    public function store(Request $request, $id)
    {
        $verification = PaymentVerification::findOrFail($id);

        // ✅ Update the verification record with verification date and message
        $verification->update([
            'status' => 'verified',
            'payment_date' => $request->date,
            'message' => $request->message ?? $verification->message,
        ]);

        // ✅ It's a ticket payment — update CustomerTicketPayment status
        if ($verification->customer_ticket_payment_id) {
            $ticketPayment = CustomerTicketPayment::find($verification->customer_ticket_payment_id);
            if ($ticketPayment) {
                $ticketPayment->update(['status' => 'completed']);
                
                // Update the related ticket's paid amount
                if ($ticketPayment->ticket_id) {
                    $ticket = CustomerTicket::find($ticketPayment->ticket_id);
                    if ($ticket) {
                        $totalPaid = CustomerTicketPayment::where('ticket_id', $ticket->id)
                            ->where('status', 'completed')
                            ->sum('paid_amount');
                        $ticket->update([
                            'paid_amount' => $totalPaid,
                            'due_amount' => $ticket->total_amount - $totalPaid
                        ]);
                    }
                }
            }
        }

        // ✅ It's an installation payment — update CustomerPayment status
        if ($verification->customer_payment_id) {
            $customerPayment = CustomerPayment::find($verification->customer_payment_id);
            if ($customerPayment) {
                $customerPayment->update(['status' => 'completed']);
                
                // Update the related customer's paid amount
                if ($customerPayment->customer_id) {
                    $customer = Customer::find($customerPayment->customer_id);
                    if ($customer) {
                        $totalPaid = CustomerPayment::where('customer_id', $customer->id)
                            ->where('status', 'completed')
                            ->sum('paid_amount');
                        $customer->update([
                            'paid_amount' => $totalPaid,
                            'due_amount' => $customer->total_amount - $totalPaid
                        ]);
                    }
                }
            }
        }

        return back()->with('success', 'Payment verified successfully.');
    }
}