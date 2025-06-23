<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Database\factories\SupplierFactory;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'branch_id',
        'created_by',
        'email',
        'contact',
        'address',
        'vat',
        'pan',
        'discription',
        'type',
        'status',
    ];
    
    protected static function newFactory(): SupplierFactory
    {
        //return SupplierFactory::new();
    }

    public function DevicePurchase()
    {
        return $this->hasMany(DevicePurchase::class);
    }
}
