<?php

namespace Modules\Lead\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Lead\Database\factories\CustomerAccessoryFactory;
use Modules\Product\Entities\Accessory;

class CustomerAccessory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table='customer_accessories';
    protected $fillable = [
        'lead_id',
        'branch_id',
        'created_by',
        'accessory_id',
        'customer_id',
        'accessory_qty',
        'status',
        'accessory_price',
        'accessory_total'
    ];
    public function accessory()
    {
        return $this->belongsTo(Accessory::class,'accessory_id','id');
    }
  
    protected static function newFactory(): CustomerAccessoryFactory
    {
        //return CustomerAccessoryFactory::new();
    }
}
