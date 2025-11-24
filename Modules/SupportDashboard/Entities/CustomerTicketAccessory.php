<?php

namespace Modules\SupportDashboard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Accessory;
use Modules\SupportDashboard\Database\factories\CustomerTicketAccessoryFactory;

class CustomerTicketAccessory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'ticket_id',
        'branch_id',
        'created_by',
        'accessory_id',
        'customer_id',
        'accessory_qty',
        'status',
        'accessory_price',
        'accessory_total'
    ];

    public function accessory()
    {
        return $this->belongsTo(Accessory::class, 'accessory_id');
    }
}
