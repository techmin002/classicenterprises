<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\TechnicalTools;

class StockTransfer extends Model
{
    use HasFactory;

    protected $table = 'stock_transfers';

    protected $fillable = [
        'stock_issue_id',
        'from_branch_id',
        'to_branch_id',
        'transfer_date',
        'status',
        'remarks',
        'created_by',
        'updated_by',
    ];
protected $dates = ['transfer_date', 'received_at', 'created_at', 'updated_at'];

    public function fromBranch()
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    public function toBranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
 

public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
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
        )->withPivot(['quantity', 'serial_numbers', 'condition'])
        ->withTimestamps();
    }

    public function accessories()
    {
        return $this->belongsToMany(
            Accessories::class,
            'stock_transfer_accessories',
            'stock_transfer_id', // Foreign key on stock_transfer_accessories table
            'accessory_id',      // Foreign key on the related model (if different from accessories_id)
            'id',               // Local key on stock_transfers table
            'id'                // Local key on accessories table
        )->withPivot(['quantity', 'serial_numbers', 'condition'])
        ->withTimestamps();
    }

    public function technicaltools()
    {
        return $this->belongsToMany(
            TechnicalTools::class,
            'stock_transfer_technical_tools',
            'stock_transfer_id', // Foreign key on stock_transfer_accessories table
            'technical_tool_id',      // Foreign key on the related model (if different from accessories_id)
            'id',               // Local key on stock_transfers table
            'id'                // Local key on accessories table
        )->withPivot(['quantity', 'serial_numbers', 'condition'])
        ->withTimestamps();
    }

    public function stockIssue()
    {
        return $this->belongsTo(StockIssue::class, 'stock_issue_id');
    }
}
