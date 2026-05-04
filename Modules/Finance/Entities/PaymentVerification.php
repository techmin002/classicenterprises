<?php

namespace Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;
use Modules\Finance\Database\factories\PaymentVerificationFactory;
use Modules\Lead\Entities\Customer;
use Modules\Lead\Entities\CustomerPayment;
use Modules\Lead\Entities\Lead;
use Modules\SupportDashboard\Entities\CustomerTicket;
use Modules\SupportDashboard\Entities\CustomerTicketPayment;

class PaymentVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        // ✅ New linked payment IDs
        'customer_payment_id',
        'customer_ticket_payment_id',
        'ticket_id',

        // Existing fields
        'customer_id',
        'lead_id',
        'branch_id',
        'total_amount',
        'paid_amount',
        'remaining_amount',
        'payment_method',
        'payment_date',
        'status',
        'message',
        'receipt',
        'created_by',
    ];

    // ===============================
    // ✅ Relationships
    // ===============================

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    // ✅ Link to installation payment record
    public function customerPayment()
    {
        return $this->belongsTo(CustomerPayment::class, 'customer_payment_id');
    }

    // ✅ Link to ticket payment record
    public function customerTicketPayment()
    {
        return $this->belongsTo(CustomerTicketPayment::class, 'customer_ticket_payment_id');
    }

    // ✅ Link to ticket
    public function ticket()
    {
        return $this->belongsTo(CustomerTicket::class, 'ticket_id');
    }

    // ===============================
    // ✅ Accessors
    // ===============================

    public function getCustomerNameAttribute()
    {
        return optional($this->customer)->name
            ?? optional(optional($this->customer)->lead)->name
            ?? '-';
    }

    public function getLeadNameAttribute()
    {
        return optional($this->lead)->name
            ?? optional(optional($this->customer)->lead)->name
            ?? '-';
    }

    public function getMethodAttribute()
    {
        return $this->payment_method ?: '-';
    }

    // ✅ Know if this verification is for a ticket or installation
    public function getTypeAttribute()
    {
        return $this->ticket_id ? 'Ticket' : 'Installation';
    }

    protected static function newFactory()
    {
        // return PaymentVerificationFactory::new();
    }
}