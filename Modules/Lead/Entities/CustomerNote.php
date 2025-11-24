<?php

namespace Modules\Lead\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Lead\Database\factories\CustomerNoteFactory;

class CustomerNote extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'lead_id',
        'customer_id',
        'note'
    ];

    protected static function newFactory()
    {
        //return CustomerNoteFactory::new();
    }
}
