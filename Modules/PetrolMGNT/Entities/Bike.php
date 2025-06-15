<?php

namespace Modules\PetrolMGNT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;
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
        'status',
        'branch_id'
    ];

    protected static function newFactory(): BikeFactory
    {
        //return BikeFactory::new();
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
