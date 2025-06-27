<?php

namespace Modules\OutSiderSupportDashboard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\OutSiderSupportDashboard\Database\factories\OuterServiceItemFactory;

class OuterServiceItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): OuterServiceItemFactory
    {
        //return OuterServiceItemFactory::new();
    }
}
