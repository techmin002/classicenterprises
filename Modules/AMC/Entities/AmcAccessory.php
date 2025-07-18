<?php

namespace Modules\AMC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AMC\Database\factories\AmcAccessoryFactory;
use Modules\Product\Entities\Accessory;

class AmcAccessory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['amc_id', 'accessory_id', 'quantity'];

    public function amc()
    {
        return $this->belongsTo(Amc::class, 'amc_id');
    }

    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }

    protected static function newFactory()
    {
        //return AmcAccessoryFactory::new();
    }
}
