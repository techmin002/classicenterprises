<?php

namespace Modules\Lead\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Lead\Database\factories\CustomerPaymentFactory;

class CustomerPayment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'customer_payments';
    protected $fillable = [
        'lead_id',
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

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    // In Modules/Lead/Entities/CustomerPayment.php
public function verification()
{
    return $this->hasOne(\Modules\Finance\Entities\PaymentVerification::class, 'customer_payment_id');
}
}
