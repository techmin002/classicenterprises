<?php

namespace Modules\PetrolMGNT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;
use Modules\PetrolMGNT\Database\factories\BikeServiceFactory;

class BikeService extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'bike_id',
        'amount',
        'mode',
        'image',
        'date',
        'km',
        'message',
        'created_by',
        'status'
    ];

    protected static function newFactory(): BikeServiceFactory
    {
        //return BikeServiceFactory::new();
    }
    public function bike()
    {
        return $this->belongsTo(Bike::class, 'bike_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
