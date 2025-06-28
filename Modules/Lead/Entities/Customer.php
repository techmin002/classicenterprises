<?php

namespace Modules\Lead\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Branch\Entities\Branch;
use Modules\Lead\Database\factories\CustomerFactory;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table='customers';
    protected $fillable = [
        'lead_id',
        'branch_id',
        'created_by',
        'total_amount',
        'paid_amount',
        'due_amount',
        'status',
        'customer_type',
        'sales_type',
        'install_date',
        'converted_by'
    ];
    public function lead(){
        return $this->belongsTo(Lead::class);
    }
    public function payments()
    {
        return $this->hasMany(CustomerPayment::class);
    }
    protected static function newFactory(): CustomerFactory
    {
        //return CustomerFactory::new();
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

}
