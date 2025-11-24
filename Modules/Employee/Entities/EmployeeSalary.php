<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeSalary extends Model
{
    use HasFactory;

    protected $fillable = ['salary','employee_id','status'];
    
    protected static function newFactory()
    {
        return \Modules\Employee\Database\factories\EmployeeSalaryFactory::new();
    }
}
