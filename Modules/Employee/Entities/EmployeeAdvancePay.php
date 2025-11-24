<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeAdvancePay extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'amount',
        'title',
        'date',
        'reason',
        'status'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Employee\Database\factories\EmployeeAdvancePayFactory::new();
    }
}
