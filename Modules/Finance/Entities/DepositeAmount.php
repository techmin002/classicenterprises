<?php
namespace Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositeAmount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'closing_balance_id', 'amount', 'bank_name',
        'image', 'date', 'status', 'notes',
    ];

    protected $casts = [
        'date'   => 'date',
        'amount' => 'decimal:2',
    ];

    /** The closing day this deposit is clearing */
    public function closingBalance()
    {
        return $this->belongsTo(ClosingBalance::class, 'closing_balance_id');
    }
}