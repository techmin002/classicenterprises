<?php

namespace Modules\OutSiderSupportDashboard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;
use Modules\Lead\Entities\Customer;
use Modules\OutSiderSupportDashboard\Database\factories\OutSideTaskFactory;

class OutSideTask extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'product',
        'email',
        'contact',
        'date',
        'branch_id',
        'support_type',
        'priority',
        'message',
        'created_by',
        'address',
        'home_address',
    ];

    protected static function newFactory()
    {
        //return OutSideTaskFactory::new();
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function outer_service_items()
    {
        return $this->hasMany(OuterServiceItem::class, 'task_id', 'id');
    }
}
