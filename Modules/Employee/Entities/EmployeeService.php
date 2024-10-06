<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeService extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id','amount','date','title','status','created_by','description','status'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Employee\Database\factories\EmployeeServiceFactory::new();
    }
}
