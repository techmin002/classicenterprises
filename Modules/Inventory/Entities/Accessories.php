<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Database\factories\AccessoriesFactory;

class Accessories extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * Optional if Laravel can infer from model name (plural 'accessories')
     *
     * @var string
     */
    protected $table = 'accessories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
        // add any other columns here
    ];

    /**
     * Define the factory for the Accessories model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return AccessoriesFactory::new();
    }

    /**
     * Relationship: One accessory can be attached to many device purchases via pivot.
     */
    public function devicePurchases()
    {
        // Many-to-Many relationship with DevicePurchase through pivot table
        return $this->belongsToMany(
            DevicePurchase::class,              // Related model
            'device_purchase_accessories',     // Pivot table name
            'accessory_id',                    // Foreign key on pivot for Accessories
            'device_purchase_id'   
                        // Foreign key on pivot for DevicePurchase
        )
        ->withPivot(['quantity', 'unit_price', 'total', 'branch_id'])
        ->withTimestamps();
    }

    /**
     * (Optional) If you have a direct model for the pivot table,
     * you can also define a hasMany for that.
     */
    public function devicePurchaseAccessories()
    {
        return $this->hasMany(DevicePurchaseAccessory::class, 'accessory_id');
    }

    /**
     * Scope to get only active accessories (if you use a status column)
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'on');
    }
}
