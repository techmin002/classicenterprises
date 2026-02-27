<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\Entities\Accessories;
use Modules\Inventory\Entities\TechnicalTool;

class StaffItemAssignment extends Model
{
    use HasFactory;

    protected $table = 'staff_item_assignments';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'staff_id',
        'branch_id',
        'item_type',
        'item_id',
        'assigned_qty',
        'assigned_by',
        'assigned_at',
        'status',
        'remarks',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    /* =========================
     | Relationships
     ========================= */

    /**
     * Staff (User with role = staff)
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Return record for this assignment
     */
   public function returns()
{
    return $this->hasMany(StaffItemReturn::class, 'assignment_id');
}
public function getProcessedQtyAttribute()
{
    return $this->returns->sum(function ($r) {
        return $r->returned_qty + $r->used_qty + $r->broken_qty;
    });
}

public function getRemainingQtyAttribute()
{
    return $this->assigned_qty - $this->processed_qty;
}
public function getTotalReturnedAttribute()
{
    return $this->returns->sum('returned_qty');
}

public function getTotalUsedAttribute()
{
    return $this->returns->sum('used_qty');
}

public function getTotalBrokenAttribute()
{
    return $this->returns->sum('broken_qty');
}


    /**
     * User who assigned the item
     */
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * Branch
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Polymorphic-like relation for item
     */
    public function item()
    {
        if ($this->item_type === 'accessory') {
            return $this->belongsTo(Accessories::class, 'item_id');
        }

        if ($this->item_type === 'technical_tool') {
            return $this->belongsTo(TechnicalTool::class, 'item_id');
        }

        // Fallback
        return $this->belongsTo(Accessories::class, 'item_id');
    }

    /* =========================
     | Query Scopes
     ========================= */

    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function scopeByBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    /* =========================
     | Helpers / Business Logic
     ========================= */

    public function isAssigned(): bool
    {
        return $this->status === 'assigned';
    }

    public function isReturned(): bool
    {
        return $this->status === 'returned';
    }

    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    /* =========================
     | Accessors
     ========================= */

    /**
     * Get the display name of the assigned item.
     * Handles accessory or technical tool dynamically.
     */
    public function getItemNameAttribute(): string
    {
        return match($this->item_type) {
            'accessory' => optional(Accessories::find($this->item_id))->name,
            'technical_tool' => optional(TechnicalTool::find($this->item_id))->tool_name,
            default => 'N/A',
        };
    }
}
