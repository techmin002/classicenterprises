<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'employee_id',
        'leave_type_id',
        'branch_id',
        'start_date',
        'end_date',
        'message',
        'status'
    ];
    
 public function branch()
{
    return $this->belongsTo(\Modules\Branch\Entities\Branch::class, 'branch_id');
}

public function employee()
{
    return $this->belongsTo(Employee::class, 'employee_id');
}

public function leaveType()
{
    return $this->belongsTo(LeaveType::class, 'leave_type_id');
}
}
