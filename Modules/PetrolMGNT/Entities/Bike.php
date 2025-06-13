<?php

namespace Modules\PetrolMGNT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PetrolMGNT\Database\factories\BikeFactory;

class Bike extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'model',
        'bikenumber',
        'created_by',
        'status'
    ];

    protected static function newFactory(): BikeFactory
    {
        //return BikeFactory::new();
    }


}
