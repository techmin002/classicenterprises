<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'branch_id',
        'check_in',
        'check_out',
        'status',
        'date'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Employee\Database\factories\EmployeeAttendanceFactory::new();
    }
}
