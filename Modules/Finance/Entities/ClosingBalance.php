<?php
// ── ClosingBalance.php ──────────────────────────────────────────
namespace Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClosingBalance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'amount', 'cash_amount', 'online_amount',
        'date', 'status', 'notes',
    ];

    protected $casts = [
        'date'         => 'date',
        'amount'       => 'decimal:2',
        'cash_amount'  => 'decimal:2',
        'online_amount'=> 'decimal:2',
    ];

    /** Deposits made against this closing day */
    public function deposits()
    {
        return $this->hasMany(DepositeAmount::class, 'closing_balance_id');
    }

    /** Net cash still owed for this closing day */
    public function getRemainingCashAttribute(): float
    {
        $deposited = $this->deposits()->sum('amount');
        return max(0, (float)$this->cash_amount - (float)$deposited);
    }
}
