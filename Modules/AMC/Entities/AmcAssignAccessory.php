<?php

namespace Modules\AMC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AMC\Database\factories\AmcAssignAccessoryFactory;
use Modules\Product\Entities\Accessory;

class AmcAssignAccessory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'amc_assign_id',
        'customer_id',
        'amc_id',
        'accessory_id',
        'quantity',
    ];

    protected static function newFactory()
    {
        //return AmcAssignAccessoryFactory::new();
    }
    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }
}
