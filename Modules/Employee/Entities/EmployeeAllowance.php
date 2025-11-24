<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeAllowance extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount','type','title','status','employee_id'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Employee\Database\factories\EmployeeAllowanceFactory::new();
    }
}
