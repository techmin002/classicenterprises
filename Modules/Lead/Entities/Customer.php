<?php

namespace Modules\Lead\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AMC\Entities\AmcCustomer;
use Modules\Branch\Entities\Branch;
use Modules\Lead\Database\factories\CustomerFactory;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'customers';

    protected $fillable = [
        'user_name',
        'lead_id',
        'branch_id',
        'created_by',
        'converted_by',
        'install_date',
        'branch_id',
        'exchange_amount',
        'total_amount',
        'paid_amount',
        'due_amount',
        'customer_type',
        'sales_type',
        'installation_category',
        'message',
        'ticket_status',
        'status',
        'gifted',
        'warranty_in',
        'warranty_out',
        'warranty__service_date',
        'warranty_lifetime',
        'payment_status',
        'payment_method',
        'cash_amount',
        'cash_receipt',
        'online_amount',
        'online_receipt',
        'cheque_amount',
        'cheque_number',
        'cheque_receipt',
        'grand_total',
        'product_document',
        'warranty_card',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function payments()
    {
        return $this->hasMany(CustomerPayment::class);
    }

    protected static function newFactory()
    {
        // return CustomerFactory::new();
    }

    public function products()
    {
        return $this->hasMany(CustomerProduct::class)->with('product');
    }

    public function accessories()
    {
        return $this->hasMany(CustomerAccessory::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function emiCustomer()
    {
        return $this->hasOne(EmiCustomer::class);
    }

    public function assignLead()
    {
        return $this->belongsTo(User::class, 'assign_to', 'id');
    }

    public function convertedBy()
    {
        return $this->belongsTo(User::class, 'converted_by');
    }

    public function registerAmc()
    {
        return $this->hasOne(AmcCustomer::class, 'customer_id')->latest('date');
    }
}
