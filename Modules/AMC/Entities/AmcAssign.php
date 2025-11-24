<?php

namespace Modules\AMC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AMC\Database\factories\AmcAssignFactory;
use Modules\Lead\Entities\Customer;

class AmcAssign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'amc_id',
        'branch_id',
        'image',
        'date',
        'amount',
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

    protected static function newFactory()
    {
        //return AmcAssignFactory::new();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function amc()
    {
        return $this->belongsTo(AMC::class, 'amc_id');
    }
}
