<?php

namespace Modules\EMISystem\Entities;

use Illuminate\Database\Eloquent\Model;

class EmiPlan extends Model
{
    protected $table = 'emiS'; // Your custom table name
    
    protected $fillable = [
        'title',
        'duration', 
        'interest_rate',
        'description',
        'status'
    ];
}