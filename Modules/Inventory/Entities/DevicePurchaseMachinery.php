<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class DevicePurchaseMachinery extends Model
{
    protected $fillable = [
        'device_purchase_id', 'machinery_id', 'branch_id', 'quantity', 'unit_price', 'total',
    ];

    public function devicePurchase()
    {
        return $this->belongsTo(DevicePurchase::class);
    }
    public function machinery()
{
    return $this->hasOne(Machineries::class , 'id', 'machinery_id');
}

    public function accessories()
    {
        return $this->hasMany(Accessories::class,);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function machineries()
    {
        return $this->belongsTo(Machineries::class);
    }

    
}
