<?php
namespace Modules\Product\Entities;
use Modules\Branch\Entities\Branch;
use Modules\Product\Entities\Accessory;

use Illuminate\Database\Eloquent\Model;

class AccessoryStock extends Model
{
    protected $table = 'accessory_stocks';

    protected $fillable = [
        'accessory_id',
        'branch_id',
        'stock_in',
        'total_stock',
        'stock_alert',
        'created_by',
        'status',
    ];

    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
