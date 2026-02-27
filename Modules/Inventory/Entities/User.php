<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class User extends Model
{
    use HasFactory, HasRoles;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];


    public function devicePurchases()
    {
        return $this->hasMany(DevicePurchase::class, 'created_by');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function staffItemAssignments()
{
    return $this->hasMany(StaffItemAssignment::class, 'staff_id');
}
}
