<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeAttendanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'branch_id',
        'request_type',
        'message',
        'status',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id','user_id');
    }
    protected static function newFactory()
    {
        return \Modules\Employee\Database\factories\EmployeeAttendanceRequestFactory::new();
    }
}
