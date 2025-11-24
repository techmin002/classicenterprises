<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Database\factories\StockIssueMachineryFactory;
use Modules\Product\Entities\Machinery;

class StockIssueMachinery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['stock_issue_id', 'machinery_id', 'quantity'];


    protected static function newFactory()
    {
        //return StockIssueMachineryFactory::new();
    }
    public function machinery()
    {
        return $this->belongsTo(Machinery::class);
    }
}
