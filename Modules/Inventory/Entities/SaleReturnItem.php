<?php
namespace Modules\Inventory\Entities;


use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\Entities\SaleReturn;  
use Modules\Inventory\Entities\Accessories;
use Modules\Inventory\Entities\Machineries;

class SaleReturnItem extends Model
{

    protected $fillable = [
        'sale_return_id',
        'accessory_id',
        'machinery_id',
        'name',
        'quantity',
        'price',
        'total'
    ];

    public function saleReturn()
    {
        return $this->belongsTo(SaleReturn::class);
    }
     public function accessory()
    {
        return $this->belongsTo(Accessories::class, 'accessory_id');
    }

    public function machinery()
    {
        return $this->belongsTo(Machineries::class, 'machinery_id');
    }
}