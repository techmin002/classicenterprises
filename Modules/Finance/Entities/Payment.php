<?php

namespace Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Finance\Database\factories\PaymentFactory;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'amount',
        'payment_method',
        'payment_date',
        'status',
        'message',
    ];

    protected static function newFactory(): PaymentFactory
    {
        //return PaymentFactory::new();
    }
}
