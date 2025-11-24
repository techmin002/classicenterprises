<?php

namespace Modules\PetrolMGNT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PetrolMGNT\Database\factories\PetrolPumpFactory;

class PetrolPump extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'location',
    ];

    protected static function newFactory()
    {
        //return PetrolPumpFactory::new();
    }
}
