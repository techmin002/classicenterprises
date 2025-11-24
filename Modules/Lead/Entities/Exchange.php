<?php

namespace Modules\Lead\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Lead\Database\factories\ExchangeFactory;

class Exchange extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'lead_id',
        'branch_id',
        'customer_id',
        'item_name',
        'item_amount',
    ];

    protected static function newFactory()
    {
        //return ExchangeFactory::new();
    }
}
