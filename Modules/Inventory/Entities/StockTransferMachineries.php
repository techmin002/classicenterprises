<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockTransferMachineries extends Model
{
    use HasFactory;

    protected $table = 'stock_transfer_machineries';
    protected $fillable = [
        'stock_transfer_id',
        'machinery_id',
        'quantity',
        'serial_numbers',
        'condition'
    ];

    public function stockTransfer()
    {
        return $this->belongsTo(StockTransfer::class);
    }

    public function machinery()
    {
        return $this->belongsTo(Machineries::class);
    }
}