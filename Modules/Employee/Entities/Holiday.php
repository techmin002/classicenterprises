<?php
namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable = [
        'title',
        'date'
    ];
}