<?php

namespace Modules\SupportDashboard\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutsiderCustomer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'branch_id',
        'user_name',
        'address',
        'email',
        'contact_no',
        'landline',
        'product_name',
        'last_service_date',
        'status',
    ];
}
