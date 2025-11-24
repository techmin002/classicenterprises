<?php

namespace Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmiPayment extends Model
{
    use HasFactory;

    protected $fillable = [
    'emi_customers_id',
    'customer_id',
    'payment',
    'payment_method',
    'date',
    'receipt',
    'message',
    'status',
];


    public function customer()
    {
        return $this->belongsTo(\Modules\Lead\Entities\Customer::class);
    }

    public function emiCustomer()
    {
        return $this->belongsTo(\Modules\Lead\Entities\EmiCustomer::class, 'emi_customers_id');
    }
}
