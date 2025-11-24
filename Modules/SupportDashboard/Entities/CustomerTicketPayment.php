<?php

namespace Modules\SupportDashboard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SupportDashboard\Database\factories\CustomerTicketPaymentFactory;

class CustomerTicketPayment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'ticket_id',
        'branch_id',
        'created_by',
        'customer_id',
        'paid_amount',
        'payment_method',
        'cash_amount',
        'cash_receipt',
        'online_amount',
        'online_receipt',
        'cheque_amount',
        'cheque_number',
        'cheque_receipt',
        'status',
    ];
}
