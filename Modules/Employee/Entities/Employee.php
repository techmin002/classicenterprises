<?php

namespace Modules\Employee\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function salary()
    {
        return $this->hasOne(EmployeeSalary::class);
    }
    public function allowance()
    {
        return $this->hasMany(EmployeeAllowance::class,'employee_id','id');
    }
    public function insentive()
    {
        return $this->hasMany(EmployeeSaleInsentive::class,'employee_id','id');
    }
    public function advancePay()
    {
        return $this->hasMany(EmployeeAdvancePay::class,'employee_id','id');
    }
    public function fund()
    {
        return $this->hasMany(EmployeeFund::class,'employee_id','id');
    }
    public function service()
    {
        return $this->hasMany(EmployeeService::class,'employee_id','id');
    }
    protected static function newFactory()
    {
        return \Modules\Employee\Database\factories\EmployeeFactory::new();
    }
}
