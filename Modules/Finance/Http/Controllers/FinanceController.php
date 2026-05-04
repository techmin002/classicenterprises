<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Lead\Entities\Customer;
use Modules\Lead\Entities\CustomerPayment;
use Modules\SupportDashboard\Entities\CustomerTicketPayment;
use Modules\SupportDashboard\Entities\CustomerTicket;


class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('finance::Payment.index', compact('customers'));
    }

public function show($id)
{
    $customer = Customer::with(['lead', 'branch', 'convertedBy'])->findOrFail($id);

    // Installation payments with verification relationship
    $payments = CustomerPayment::where('customer_id', $id)
        ->with(['verification'])  // Using the relationship
        ->oldest()
        ->get();

    // Debug: Check if payments have verification
    \Log::info('Installation Payments', [
        'customer_id' => $id,
        'payment_count' => $payments->count(),
        'payments_with_verification' => $payments->filter(function($p) { return $p->verification; })->count()
    ]);

    // Ticket payments with verification relationship
    $ticketPayments = CustomerTicketPayment::where('customer_id', $id)
        ->with(['ticket', 'verification'])
        ->latest()
        ->get();

    // Installation totals
    $installTotal = $customer->total_amount ?? 0;
    $installPaid  = $customer->paid_amount  ?? 0;
    $installDue   = $customer->due_amount   ?? 0;

    // Ticket totals
    $ticketTotal = CustomerTicket::where('customer_id', $id)->sum('total_amount');
    $ticketPaid  = CustomerTicket::where('customer_id', $id)->sum('paid_amount');
    $ticketDue   = CustomerTicket::where('customer_id', $id)->sum('due_amount');

    // Grand totals
    $grandTotal = $installTotal + $ticketTotal;
    $grandPaid  = $installPaid  + $ticketPaid;
    $grandDue   = $installDue   + $ticketDue;

    $ticketsDue = CustomerTicket::where('customer_id', $id)
        ->where('due_amount', '>', 0)
        ->where('status', 'complete')
        ->get();

    // Ticket payment count per ticket
    $ticketPaymentCounts = CustomerTicketPayment::where('customer_id', $id)
        ->selectRaw('ticket_id, COUNT(*) as pay_count')
        ->groupBy('ticket_id')
        ->pluck('pay_count', 'ticket_id');

    return view('finance::Payment.show', compact(
        'customer', 'payments', 'ticketPayments',
        'installTotal', 'installPaid', 'installDue',
        'ticketTotal',  'ticketPaid',  'ticketDue',
        'grandTotal',   'grandPaid',   'grandDue',
        'ticketsDue',   'ticketPaymentCounts'
    ));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'customer_id'  => 'required',
        'amount'       => 'required|numeric|min:1',
        'payment_mode' => 'required',
        'date'         => 'required|date',
        'payment_for'  => 'required|in:installation,ticket',
    ]);

    // ✅ Handle receipt upload
    $receiptFileName = null;
    if ($request->hasFile('receipt')) {
        $file            = $request->file('receipt');
        $receiptFileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('receipts'), $receiptFileName);
    }

    // ==========================================
    // ✅ TICKET PAYMENT
    // ==========================================
    if ($request->payment_for === 'ticket') {

        $ticket = CustomerTicket::findOrFail($request->ticket_id);
        $amount = min((float) $request->amount, (float) $ticket->due_amount);

        if ($amount <= 0) {
            return redirect()->back()->with('error', 'No due amount remaining for this ticket.');
        }

        // ✅ Create ticket payment
        $ticketPayment = CustomerTicketPayment::create([
            'ticket_id'      => $ticket->id,
            'customer_id'    => $ticket->customer_id,
            'branch_id'      => $ticket->branch_id,
            'created_by'     => Auth::id(),
            'paid_amount'    => $amount,
            'payment_method' => $request->payment_mode,
            'cash_amount'    => $request->payment_mode === 'cash'   ? $amount : 0,
            'online_amount'  => $request->payment_mode === 'online' ? $amount : 0,
            'cheque_amount'  => $request->payment_mode === 'cheque' ? $amount : 0,
            'cheque_number'  => $request->payment_mode === 'cheque' ? $request->cheque_no : null,
            'cash_receipt'   => $request->payment_mode === 'cash'   ? $receiptFileName : null,
            'online_receipt' => $request->payment_mode === 'online' ? $receiptFileName : null,
            'cheque_receipt' => $request->payment_mode === 'cheque' ? $receiptFileName : null,
            'status'         => 'paid',
        ]);

        // ✅ Create PaymentVerification for ticket payment
        \Modules\Finance\Entities\PaymentVerification::create([
            'customer_ticket_payment_id' => $ticketPayment->id,
            'customer_id'                => $ticket->customer_id,
            'lead_id'                    => optional(Customer::find($ticket->customer_id))->lead_id,
            'branch_id'                  => $ticket->branch_id,
            'ticket_id'                  => $ticket->id,
            'total_amount'               => $ticket->total_amount,
            'paid_amount'                => $amount,
            'remaining_amount'           => max(0, $ticket->due_amount - $amount),
            'payment_method'             => $request->payment_mode,
            'payment_date'               => $request->date,
            'status'                     => 'on',
            'message'                    => $request->remarks,
            'created_by'                 => Auth::id(),
        ]);

        // ✅ Update ticket balance
        $ticket->update([
            'paid_amount' => $ticket->paid_amount + $amount,
            'due_amount'  => max(0, $ticket->due_amount - $amount),
        ]);

        Log::create([
            'perform'   => auth()->user()->name . ' Ticket Payment: Rs.' . $amount
                         . ' for Ticket #' . $ticket->id . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        return redirect()->back()->with('success', 'Ticket payment of Rs. ' . number_format($amount) . ' added successfully.');
    }

    // ==========================================
    // ✅ INSTALLATION PAYMENT
    // ==========================================
    $customer = Customer::findOrFail($request->customer_id);
    $amount   = min((float) $request->amount, (float) $customer->due_amount);

    if ($amount <= 0) {
        return redirect()->back()->with('error', 'No due amount remaining.');
    }

    // ✅ Create installation payment
    $customerPayment = CustomerPayment::create([
        'customer_id'    => $customer->id,
        'lead_id'        => $customer->lead_id,
        'branch_id'      => $customer->branch_id,
        'created_by'     => Auth::id(),
        'paid_amount'    => $amount,
        'payment_method' => $request->payment_mode,
        'cash_amount'    => $request->payment_mode === 'cash'   ? $amount : 0,
        'online_amount'  => $request->payment_mode === 'online' ? $amount : 0,
        'cheque_amount'  => $request->payment_mode === 'cheque' ? $amount : 0,
        'cheque_number'  => $request->payment_mode === 'cheque' ? $request->cheque_no : null,
        'cash_receipt'   => $request->payment_mode === 'cash'   ? $receiptFileName : null,
        'online_receipt' => $request->payment_mode === 'online' ? $receiptFileName : null,
        'cheque_receipt' => $request->payment_mode === 'cheque' ? $receiptFileName : null,
        'status'         => 'paid',
        'created_at'     => $request->date,
        'updated_at'     => now(),
    ]);

    // ✅ Create PaymentVerification for installation payment
    \Modules\Finance\Entities\PaymentVerification::create([
        'customer_payment_id' => $customerPayment->id,
        'customer_id'         => $customer->id,
        'lead_id'             => $customer->lead_id,
        'branch_id'           => $customer->branch_id,
        'total_amount'        => $customer->total_amount,
        'paid_amount'         => $amount,
        'remaining_amount'    => max(0, $customer->due_amount - $amount),
        'payment_method'      => $request->payment_mode,
        'payment_date'        => $request->date,
        'status'              => 'on',
        'message'             => $request->remarks,
        'created_by'          => Auth::id(),
    ]);

    // ✅ Update customer balance
    $customer->update([
        'paid_amount' => $customer->paid_amount + $amount,
        'due_amount'  => max(0, $customer->due_amount - $amount),
    ]);

    Log::create([
        'perform'   => auth()->user()->name . ' Installation Payment: Rs.' . $amount
                     . ' for ' . optional($customer->lead)->name . ' at ' . now(),
        'user_id'   => auth()->user()->id,
        'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
        'url'       => url()->current(),
    ]);

    return redirect()->back()->with('success', 'Payment of Rs. ' . number_format($amount) . ' added successfully.');
}
}