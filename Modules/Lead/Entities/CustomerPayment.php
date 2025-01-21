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
    protected $table='customer_payments';
    protected $fillable = [
        'lead_id',
        'branch_id',
        'created_by',
        'product_id',
        'cutsomer_id',
        'paid_amount',
        'receipt',
        'status',
    ];

    protected static function newFactory(): CustomerPaymentFactory
    {
        //return CustomerPaymentFactory::new();
    }
}
