<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class DevicePurchase extends Model
{
    protected $fillable = [
        'supplier_id',
        'branch_id',
        'bill_no',
        'total_amount',
        'receipt',
        'status',
        'description',
        'created_by'
    ];

    public function accessories()
    {
        return $this->belongsToMany(Accessories::class)
            ->withPivot('quantity', 'price', 'total', 'branch_id');
    }

    public function machineries()
{
    return $this->belongsToMany(
        Machineries::class,
        'device_purchase_machineries',
        'device_purchase_id',
        'machinery_id'  // matches your pivot column name exactly
    )
    ->withPivot(['quantity', 'unit_price', 'total', 'branch_id'])
    ->withTimestamps();
}

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
