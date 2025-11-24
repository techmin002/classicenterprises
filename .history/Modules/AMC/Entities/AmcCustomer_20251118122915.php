<?php

namespace Modules\AMC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AMC\Database\factories\AmcCustomerFactory;
use Modules\Lead\Entities\Customer;

class AmcCustomer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'customer_name',
        'email',
        'contact',
        'landline'
        'address',
        'type',
        'amc_id',
        'branch_id',
        'image',
        'date',
        'last_date',
        'amount',
        'payment_status',
        'payment_method',
        'cash_amount',
        'cash_receipt',
        'online_amount',
        'online_receipt',
        'cheque_amount',
        'cheque_number',
        'cheque_receipt',
        'message',
        'status',
    ];
    public function amc()
    {
        return $this->belongsTo(Amc::class, 'amc_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
