<?php

namespace Modules\SupportDashboard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;
use Modules\Lead\Entities\Customer;
use Modules\SupportDashboard\Database\factories\CustomerTicketPaymentFactory;
use App\Models\User;

class CustomerTicketPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'branch_id',
        'created_by',
        'customer_id',
        'paid_amount',
        'payment_method',
        'cash_amount',
        'cash_receipt',
        'online_amount',
        'online_receipt',
        'cheque_amount',
        'cheque_number',
        'cheque_receipt',
        'status',
    ];

    // ===============================
    // ✅ Relationships
    // ===============================

    // Link to the ticket this payment belongs to
    public function ticket()
    {
        return $this->belongsTo(CustomerTicket::class, 'ticket_id');
    }

    // Link to the customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Link to the branch
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    // Who created this payment
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ===============================
    // ✅ Accessors
    // ===============================

    // Get total paid across all methods (cash + online + cheque)
    public function getTotalBreakdownAttribute(): float
    {
        return (float) ($this->cash_amount ?? 0)
             + (float) ($this->online_amount ?? 0)
             + (float) ($this->cheque_amount ?? 0);
    }

    // Human readable status label
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'paid'      => 'Pending Verification',
            'completed' => 'Completed',
            default     => ucfirst($this->status ?? 'Unknown'),
        };
    }

    // Badge color for status
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'paid'      => 'warning',
            'completed' => 'success',
            default     => 'secondary',
        };
    }

    // ===============================
    // ✅ Scopes
    // ===============================

    // Get only completed/verified payments
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Get only pending verification payments
    public function scopePending($query)
    {
        return $query->where('status', 'paid');
    }

    // Get payments for a specific customer
    public function scopeForCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    // Get payments for a specific branch
    public function scopeForBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    protected static function newFactory()
    {
        // return CustomerTicketPaymentFactory::new();
    }
  // In Modules/SupportDashboard/Entities/CustomerTicketPayment.php
public function verification()
{
    return $this->hasOne(\Modules\Finance\Entities\PaymentVerification::class, 'customer_ticket_payment_id');
}
}