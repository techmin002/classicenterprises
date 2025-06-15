<?php

namespace Modules\Pettycash\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PetrolMGNT\Entities\Petrol;
use Modules\Pettycash\Database\factories\PettyCashTransactionFactory;

class PettyCashTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'branch_id',
        'type',
        'amount',
        'total_cash_before',
        'remaining_cash_after',
        'message',
        'reference_id',
        'created_by'
    ];


    protected static function newFactory(): PettyCashTransactionFactory
    {
        //return PettyCashTransactionFactory::new();
    }
    public function petrol()
    {
        return $this->belongsTo(Petrol::class, 'reference_id');
    }
}
