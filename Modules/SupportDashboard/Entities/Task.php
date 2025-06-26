<?php

namespace Modules\SupportDashboard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Lead\Entities\Customer;
use Modules\SupportDashboard\Database\factories\TaskFactory;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'support_type',
        'priority',
        'message',
        'status',
        'created_by',
    ];

    protected static function newFactory()
    {
        //return TaskFactory::new();
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function serviceItems()
    {
         return $this->hasMany(TaskServiceItem::class, 'task_id');
    }
}
