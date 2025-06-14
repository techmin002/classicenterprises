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
        return $this->belongsTo(Machineries::class);
    }
}
