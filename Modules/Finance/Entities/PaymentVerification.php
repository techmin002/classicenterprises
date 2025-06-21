<?php

namespace Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;
use Modules\Finance\Database\factories\PaymentVerificationFactory;
use Modules\Lead\Entities\Customer;
use Modules\Lead\Entities\Lead;

class PaymentVerification extends Model
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
        'payment_date',
        'status',
        'message',
        'receipt',
        'created_by',
    ];

    protected static function newFactory()
    {
        //return PaymentVerificationFactory::new();
    }
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
}
