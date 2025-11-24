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
    
    protected static function newFactory()
    {
        return \Modules\Employee\Database\factories\LeaveFactory::new();
    }
}
