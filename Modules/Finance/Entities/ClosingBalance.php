<?php

namespace Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Finance\Database\factories\ClosingBalanceFactory;

class ClosingBalance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'amount',
        'date',
    ];

    protected static function newFactory(): ClosingBalanceFactory
    {
        //return ClosingBalanceFactory::new();
    }
}
