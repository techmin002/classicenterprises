<?php

namespace Modules\Lead\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'mobile',
        'landline',
        'email',
        'address',
        'message',
        'lead_type',
        'status',
    ];

    protected static function newFactory()
    {
        return \Modules\Lead\Database\factories\LeadFactory::new();
    }
}
