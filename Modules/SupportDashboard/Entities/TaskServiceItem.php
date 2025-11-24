<?php

namespace Modules\SupportDashboard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SupportDashboard\Database\factories\TaskServiceItemFactory;

class TaskServiceItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): TaskServiceItemFactory
    {
        //return TaskServiceItemFactory::new();
    }
}
