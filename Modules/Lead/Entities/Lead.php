<?php

namespace Modules\Lead\Entities;

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
        'followups',
        'status',
        'lead_source',
        'deleted_at'
    ];

    protected static function newFactory()
    {
        return \Modules\Lead\Database\factories\LeadFactory::new();
    }

    public function responses()
    {
        return $this->hasMany(LeadResponse::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class,'created_by','id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id','id');
    }
}
