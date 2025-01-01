<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'duration_type',
        'leaves',
        'branch_id',
        'created_by',
        'description',
        'status'
    ];
    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
    protected static function newFactory()
    {
        return \Modules\Employee\Database\factories\LeaveTypeFactory::new();
    }
}
