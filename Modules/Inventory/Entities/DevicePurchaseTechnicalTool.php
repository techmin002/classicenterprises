<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\TechnicalTools;

class DevicePurchaseTechnicalTool extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'device_purchase_id', 'technical_tool_id', 'branch_id', 'quantity', 'unit_price', 'total',
    ];

    public function devicePurchase()
    {
        return $this->belongsTo(DevicePurchase::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function technicaltools()
    {
        return $this->belongsTo(TechnicalTools::class, 'technical_tool_id', 'id');
    }
}
