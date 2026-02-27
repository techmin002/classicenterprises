<?php

namespace Modules\Inventory\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffItemReturn extends Model
{
    use HasFactory;

    protected $table = 'staff_item_returns';

    protected $fillable = [
        'assignment_id',
        'returned_qty',
        'used_qty',
        'broken_qty',
        'verified_by',
        'verified_at',
        'remarks',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    /* =========================
     | Relationships
     ========================= */

    /**
     * Related assignment
     */
    public function assignment()
    {
        return $this->belongsTo(StaffItemAssignment::class, 'assignment_id');
    }

    /**
     * User who verified return
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /* =========================
     | Business Logic
     ========================= */

    /**
     * Total quantity accounted for
     */
    public function totalProcessedQty(): int
    {
        return $this->returned_qty
             + $this->used_qty
             + $this->broken_qty;
    }

    /**
     * Check formula:
     * assigned_qty = returned + used + broken
     */
    public function isValid(): bool
    {
        return $this->assignment &&
               $this->assignment->assigned_qty === $this->totalProcessedQty();
    }

    /**
     * Mark return as verified
     */
    public function verify(int $userId): void
    {
        $this->update([
            'verified_by' => $userId,
            'verified_at' => now(),
        ]);
    }
}
