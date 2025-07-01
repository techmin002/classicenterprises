<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Database\factories\StockIssueTechnicalToolFactory;
use Modules\Product\Entities\TechnicalTools;

class StockIssueTechnicalTool extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['stock_issue_id', 'technical_tool_id', 'quantity'];


    protected static function newFactory()
    {
        //return StockIssueTechnicalToolFactory::new();
    }
    public function technicalTool()
    {
        return $this->belongsTo(TechnicalTools::class);
    }
}
