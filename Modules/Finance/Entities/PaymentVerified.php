<?php

namespace Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Finance\Database\factories\PaymentVerifiedFactory;

class PaymentVerified extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'lead_id',
        'branch_id',
        'total_amount',
        'paid_amount',
        'remaining_amount',
        'payment_method',
        'date',
        'status',
        'message',
        'receipt',
        'created_by',
    ];

    protected static function newFactory()
    {
        //return PaymentVerifiedFactory::new();
    }
}
