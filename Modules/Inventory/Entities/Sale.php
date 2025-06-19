<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'customer_name',
        'contact',
        'landline',
        'email',
        'customer_type',
        'address',
        'total_amount',
        'paid_amount',
        'balance_due',
        'payment_method',
        'payment_reference',
        'status',
        'remarks',
        'created_by'
    ];

    public function accessories()
    {
        return $this->hasMany(SaleAccessory::class);
    }

    public function machineries()
    {
        return $this->hasMany(SaleMachinery::class);
    }

    public function payments()
    {
        return $this->hasMany(CustomerPayment::class);
    }

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\SaleFactory::new();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    
}