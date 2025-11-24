<?php

namespace Modules\SupportDashboard\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AMC\Entities\AmcAssign;
use Modules\AMC\Entities\AmcCustomer;
use Modules\Branch\Entities\Branch;
use Modules\Lead\Entities\Customer;
use Modules\Product\Entities\Accessory;
use Modules\SupportDashboard\Database\factories\CustomerTicketFactory;

class CustomerTicket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'amc_customer_id',
        'user_name',
        'customer_name',
        'contact',
        'landline',
        'address',
        'email',
        'branch_id',
        'install_date',
        'type',
        'support_type',
        'service_type',
        'priority',
        'amc',
        'warranty',
        'assign_to',
        'service_charge',
        'amount',
        'total_amount',
        'paid_amount',
        'due_amount',
        'payment_date',
        'payment_status',
        'payment_method',
        'cash_amount',
        'cash_receipt',
        'online_amount',
        'online_receipt',
        'cheque_amount',
        'cheque_number',
        'cheque_receipt',
        'message',
        'status',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function amcCustomer()
    {
        return $this->belongsTo(AmcCustomer::class, 'amc_customer_id', 'id');
    }


    public function amc()
    {
        return $this->belongsTo(AmcAssign::class);
    }
    public function notes()
    {
        return $this->hasMany(TicketNote::class, 'ticket_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    public function payments()
    {
        return $this->hasMany(CustomerTicketPayment::class, 'ticket_id');
    }
    public function accessories()
    {
        return $this->hasMany(CustomerTicketAccessory::class, 'ticket_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
