<?php

namespace Modules\Lead\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        'customer_type'
    ];
    public function lead(){
        return $this->belongsTo(Lead::class);
    }
    protected static function newFactory(): CustomerFactory
    {
        //return CustomerFactory::new();
    }
}
