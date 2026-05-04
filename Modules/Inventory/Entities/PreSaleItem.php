<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreSaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pre_sale_id',
        'type',
        'product_id',
        'name',
        'quantity',
        'price',
        'total',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function preSale()
    {
        return $this->belongsTo(PreSale::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isAccessory()
    {
        return $this->type === 'accessory';
    }

    public function isMachinery()
    {
        return $this->type === 'machinery';
    }
}