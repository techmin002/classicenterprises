<?php
namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class TechnicalTool extends Model
{
    protected $table = 'technical_tools';
    protected $fillable = ['tool_name','code','description','status'];

    // Inventory relationship
    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'technical_tool_id');
    }

    // Staff assignments for this tool
    public function assignments()
    {
        return $this->hasMany(StaffItemAssignment::class, 'item_id')
            ->where('item_type', 'technical_tool')
            ->where('status', 'assigned');
    }

    // Stock transfers for this tool
    public function stockTransfers()
    {
        return $this->hasMany(StockTransferTechnicalTool::class, 'technical_tool_id');
    }

    // Compute remaining stock
    public function getStockQuantityAttribute()
    {
        $totalStock = $this->inventory->stock ?? 0;

        $assignedQty = $this->assignments()->sum('assigned_qty');
        $transferredQty = $this->stockTransfers()->sum('quantity');

        $remaining = $totalStock - $assignedQty - $transferredQty;

        return max(0, $remaining); // never negative
    }
}
