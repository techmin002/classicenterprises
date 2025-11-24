<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockTransfer extends Model
{
    use HasFactory;

    protected $table = 'stock_transfers';
    protected $fillable = [
        'from_branch_id',
        'to_branch_id',
        'transfer_date',
        'status',
        'remarks',
        'created_by',
        'updated_by'
    ];

    public function fromBranch()
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    public function toBranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }

    public function machineries()
    {
        return $this->belongsToMany(
            Machineries::class,
            'stock_transfer_machineries',
            'stock_transfer_id', // Foreign key on stock_transfer_machineries table
            'machinery_id',      // Foreign key on the related model (if different from machinery_id)
            'id',                // Local key on stock_transfers table
            'id'                 // Local key on machineries table
        )->withPivot(['quantity', 'serial_numbers', 'condition']);
    }

    public function accessories()
{
    return $this->belongsToMany(Accessories::class, 'stock_transfer_accessories', 
        'stock_transfer_id', // Foreign key on stock_transfer_accessories table
        'accessory_id',      // Foreign key on the related model (if different from accessories_id)
        'id',               // Local key on stock_transfers table
        'id'                // Local key on accessories table
    )->withPivot(['quantity', 'serial_numbers', 'condition']);
}
}