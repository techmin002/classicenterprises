<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class DevicePurchaseAccessory extends Model
{
    protected $fillable = [
        'device_purchase_id', 'accessory_id', 'branch_id', 'quantity', 'unit_price', 'total',
    ];

    public function devicePurchase()
    {
        return $this->belongsTo(DevicePurchase::class);
    }
    public function accessory()
    {
        return $this->belongsTo(Accessories::class);
    }
}
