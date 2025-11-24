<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Database\factories\UserFactory;
use Spatie\Permission\Traits\HasRoles;



class User extends Model
{
    use HasFactory, HasRoles;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): UserFactory
    {
        //return UserFactory::new();
    }

    public function devicePurchases()
    {
        return $this->hasMany(DevicePurchase::class, 'created_by');
    }
}
