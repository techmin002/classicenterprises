<?php

namespace Modules\Pettycash\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;
use Modules\Pettycash\Database\factories\PettyCashTransferFactory;

class PettyCashTransfer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'branch_id',
        'amount',
        'date',
        'requested_by',
        'transfer_by',
        'description',
        'transfer_method',
        'cheque_number',
        'receipt',
    ];

    protected static function newFactory(): PettyCashTransferFactory
    {
        //return PettyCashTransferFactory::new();
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
