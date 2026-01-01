<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\TechnicalTools;

class StockTransferTechnicalTool extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'stock_transfer_technical_tools';

    protected $fillable = [
        'stock_transfer_id',
        'technical_tool_id',
        'quantity',
        'serial_numbers',
        'condition',
    ];

    public function stockTransfer()
    {
        return $this->belongsTo(StockTransfer::class);
    }

    public function technicaltools()
    {
        return $this->belongsTo(TechnicalTools::class);
    }
}
