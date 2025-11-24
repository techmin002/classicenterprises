<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockTransferAccessories extends Model
{
    use HasFactory;

    protected $table = 'stock_transfer_accessories';
    protected $fillable = [
        'stock_transfer_id',
        'accessory_id',
        'quantity',
        'serial_numbers',
        'condition'
    ];

    public function stockTransfer()
    {
        return $this->belongsTo(StockTransfer::class);
    }

    public function accessory()
    {
        return $this->belongsTo(Accessories::class);
    }
}