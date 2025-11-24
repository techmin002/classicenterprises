<?php

namespace Modules\Lead\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\EMISystem\Entities\EmiPlan;
use Modules\Finance\Entities\EmiPayment;


class EmiCustomer extends Model
{
    use HasFactory;

    protected $table = 'emi_customers';

    protected $fillable = [
        'customer_id',
        'emi_plan_id',
        'down_payment',
        'start_date',
        'end_date',
        'monthly_pay',
        'document',
        'status',
    ];

    public function emiPlan(){
        return $this->belongsTo(EmiPlan::class);
    }
    public function lead(){
         return $this->belongsTo(Lead::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function payments(){
        return $this->hasMany(EmiPayment::class, 'emi_customers_id');
    }
}
