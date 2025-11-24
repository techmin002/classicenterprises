<?php

namespace Modules\AMC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AMC\Database\factories\AMCFactory;

class AMC extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'amcs';
    protected $fillable = [
        'title',
        'year',
        'month',
        'price',
        'description',
        'image',
        'status',
    ];

9
    protected static function newFactory()
    {
        //return AMCFactory::new();
    }
    public function accessories()
    {
        return $this->hasMany(AmcAccessory::class, 'amc_id');
    }
}
