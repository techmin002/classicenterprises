<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Database\factories\BranchFactory;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'status',  // make sure this column exists in your branches table
    ];
    
    protected static function newFactory()
    {
        return BranchFactory::new();
    }

    public function devicePurchases()
    {
        return $this->hasMany(DevicePurchase::class);
    }

    // Add this active scope
    public function scopeActive($query)
    {
        return $query->where('status', 'on');
    }
}
