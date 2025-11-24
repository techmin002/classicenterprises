<?php

namespace Modules\Lead\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Branch\Entities\Branch;
use Modules\Employee\Entities\Employee;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'mobile',
        'landline',
        'email',
        'address',
        'message',
        'branch_id',
        'created_by',
        'lead_type',
        'installation_category',
        'followups',
        'status',
        'lead_source',
        'staff_id',
        'sales_type',
        'deleted_at'
    ];

    // protected static function newFactory()
    // {
    //     return \Modules\Lead\Database\factories\LeadFactory::new();
    // }

    public function responses()
    {
        return $this->hasMany(LeadResponse::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'created_by', 'id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
    public function staff()
    {
        return $this->belongsTo(User::class);
    }
    public function referByCustomer()
    {
        return $this->belongsTo(Customer::class, 'refer_by', 'id');
    }
}
