<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeSaleInsentive extends Model
{
    use HasFactory;

    protected $fillable = ['title','sale_amount','insentive_amount','type','status','description','employee_id','date'];
    
    protected static function newFactory()
    {
        return \Modules\Employee\Database\factories\EmployeeSaleInsentiveFactory::new();
    }
}
