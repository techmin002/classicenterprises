<?php

namespace Modules\Lead\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Lead\Database\factories\SkimFactory;

class Skim extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'lead_id',
        'branch_id',
        'customer_id',
        'skim_item_name',
    ];


    protected static function newFactory(): SkimFactory
    {
        //return SkimFactory::new();
    }
}
