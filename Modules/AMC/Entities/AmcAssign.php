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
        'payment_method',
        'cheque_no',
        'image',
        'date',
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
