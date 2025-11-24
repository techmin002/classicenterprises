<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeePayslip extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary','net_salary','employee_id','month','advance_pay','sales_insentive','service_insentive','allowance','fund','created_by','status'
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    protected static function newFactory()
    {
        return \Modules\Employee\Database\factories\EmployeePayslipFactory::new();
    }
}
