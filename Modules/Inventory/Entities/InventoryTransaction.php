<?php

namespace Modules\Inventory\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $table = 'inventory_transactions';

    protected $fillable = [
        'branch_id',
        'item_type',
        'item_id',
        'qty',
        'transaction_type',
        'source',
        'reference_id',
    ];

    /* =========================
     | Relationships
     ========================= */

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Reference return record
     */
    public function staffReturn()
    {
        return $this->belongsTo(StaffItemReturn::class, 'reference_id');
    }

    /**
     * Related item
     */
    public function item()
    {
        return match ($this->item_type) {
            'accessory'      => $this->belongsTo(DevicePurchaseAccessory::class, 'item_id'),
            'technical_tool' => $this->belongsTo(DevicePurchaseTechnicalTool::class, 'item_id'),
            default          => null,
        };
    }

    /* =========================
     | Scopes
     ========================= */

    public function scopeUsed($query)
    {
        return $query->where('transaction_type', 'used');
    }

    public function scopeBroken($query)
    {
        return $query->where('transaction_type', 'broken');
    }

    public function scopeByBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }
}
