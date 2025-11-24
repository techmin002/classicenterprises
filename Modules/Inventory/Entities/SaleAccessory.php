<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleAccessory extends Model
{
    use HasFactory;

     protected $table = 'sales_accessories';

    protected $fillable = [
        'sale_id',
        'accessory_id',
        'name',
        'quantity',
        'price',
        'total',
        'warranty'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function accessory()
    {
        return $this->belongsTo(Accessories::class);
    }

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\SaleAccessoryFactory::new();
    }
}