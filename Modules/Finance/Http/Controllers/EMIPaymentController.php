<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Lead\Entities\Customer;
use Modules\Lead\Entities\EmiCustomer;
use Modules\Finance\Entities\EmiPayment;
use Modules\Finance\Entities\Payment;
use Illuminate\Support\Facades\Storage;

class EMIPaymentController extends Controller
{
    /**
     * Display a listing of EMI customers
     */
    public function index()
    {
        $emiCustomers = EmiCustomer::with(['customer.lead', 'payments', 'emiPlan'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('finance::emiPayments.index', compact('emiCustomers'));
    }

    /**
     * Show EMI payment details for a specific customer
     */
   public function emiPaymentDetails($id)
{
    $emiCustomer = EmiCustomer::with([
        'customer.lead', 
        'payments' => function($query) {
            $query->orderBy('date', 'desc');
        }
    ])->findOrFail($id);

    // Safely calculate total paid (handle case when payments is null or empty)
    $totalPaid = $emiCustomer->payments ? $emiCustomer->payments->sum('payment') : 0;
    
    // Ensure total_amount exists and is numeric
    $totalAmount = $emiCustomer->customer->total_amount ?? 0;
    $dueAmount = max(0, $totalAmount - $totalPaid);

    return view('finance::emiPayments.detail', compact(
        'emiCustomer',
        'totalPaid',
        'dueAmount'
    ));
}

    /**
     * Store a new EMI payment
     */
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        DB::beginTransaction();

        try {
            $emiCustomer = EmiCustomer::with('customer.lead')->findOrFail($validated['emi_customers_id']);

            // Process file upload if present
            $receiptPath = $this->handleReceiptUpload($request);

            // Create payment record
            $this->createPaymentRecords($validated, $emiCustomer, $receiptPath);

            // Update customer's payment status
            $this->updateCustomerPayment($emiCustomer, $validated['payment']);

            DB::commit();

            return redirect()->back()
                ->with('success', 'EMI payment recorded successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error processing payment: ' . $e->getMessage());
        }
    }

    /**
     * Validate the incoming request
     */
    protected function validateRequest(Request $request)
    {
        return $request->validate([
            'emi_customers_id' => 'required|exists:emi_customers,id',
            'customer_id' => 'required|exists:customers,id',
            'payment' => 'required|numeric|min:1',
            'date' => 'required|date',
            'payment_mode' => 'required|in:online,cash,cheque',
            'status' => 'required|in:0,1',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'message' => 'nullable|string|max:1000',
            'cheque_no' => 'nullable|string|max:255|required_if:payment_mode,cheque',
        ]);
    }

    /**
     * Handle receipt file upload
     */
    protected function handleReceiptUpload(Request $request)
    {
        if (!$request->hasFile('receipt')) {
            return null;
        }

        return $request->file('receipt')->store('receipts', 'public');
    }

    /**
     * Create payment records in both tables
     */
    protected function createPaymentRecords(array $validated, EmiCustomer $emiCustomer, ?string $receiptPath)
    {
        // Prepare message with cheque number if applicable
        $message = $validated['message'] ?? '';
        if ($validated['payment_mode'] === 'cheque' && !empty($validated['cheque_no'])) {
            $message = 'Cheque No: ' . $validated['cheque_no'] . ($message ? ' | ' . $message : '');
        }

        // Create EMI payment record
        EmiPayment::create([
            'emi_customers_id' => $validated['emi_customers_id'],
            'customer_id' => $validated['customer_id'],
            'payment' => $validated['payment'],
            'date' => $validated['date'],
            'payment_method' => $validated['payment_mode'],
            'receipt' => $receiptPath,
            'message' => $message,
            'status' => $validated['status'],
        ]);

        // Create general payment record
        Payment::create([
            'name' => $emiCustomer->customer->lead->name,
            'amount' => $validated['payment'],
            'payment_method' => $validated['payment_mode'],
            'payment_date' => $validated['date'],
            'status' => $validated['status'],
            'message' => $message,
        ]);
    }

    /**
     * Update customer's payment status
     */
    protected function updateCustomerPayment(EmiCustomer $emiCustomer, float $paymentAmount)
    {
        $emiCustomer->increment('down_payment', $paymentAmount);
        
        // Optional: Mark as fully paid if balance is cleared
        $totalAmount = $emiCustomer->customer->total_amount;
        $paidAmount = $emiCustomer->down_payment + $paymentAmount;
        
        if ($paidAmount >= $totalAmount) {
            $emiCustomer->update(['status' => 'completed']);
        }
    }
}