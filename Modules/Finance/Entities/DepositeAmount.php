<?php

namespace Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Finance\Database\factories\DepositeAmountFactory;

class DepositeAmount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['amount', 'bank_name', 'image', 'date','status'];

    protected static function newFactory()
    {
        //return DepositeAmountFactory::new();
    }
}
