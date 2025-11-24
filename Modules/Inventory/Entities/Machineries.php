<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Database\factories\MachineriesFactory;

class Machineries extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): MachineriesFactory
    {
        return MachineriesFactory::new();
    }

    public function devicePurchases()
    {
        return $this->hasMany(DevicePurchaseMachinery::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function devicePurchasesMachineries()
    {
        return $this->hasMany(DevicePurchaseMachinery::class);
    }

    public function stockTransfers()
{
    return $this->belongsToMany(StockTransfer::class, 'stock_transfer_machineries')
        ->withPivot(['quantity', 'serial_numbers', 'condition']);
}


    
}
