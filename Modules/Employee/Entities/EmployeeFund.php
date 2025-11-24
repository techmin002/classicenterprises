<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeFund extends Model
{
    use HasFactory;

    protected $fillable = ['amount','month','employee_id','status'];
    
    protected static function newFactory()
    {
        return \Modules\Employee\Database\factories\EmployeeFundFactory::new();
    }
}
