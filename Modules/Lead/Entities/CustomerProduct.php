<?php

namespace Modules\Lead\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Lead\Database\factories\CustomerProductFactory;

class CustomerProduct extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table='customer_products';
    protected $fillable = [
        'lead_id',
        'branch_id',
        'created_by',
        'product_id',
        'customer_id',
        'product_price',
        'product_qty',
        'product_total',
        'status',
        'remarks'
    ];

    protected static function newFactory(): CustomerProductFactory
    {
        //return CustomerProductFactory::new();
    }
}
