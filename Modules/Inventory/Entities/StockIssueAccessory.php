<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Database\factories\StockIssueAccessoryFactory;
use Modules\Product\Entities\Accessory;

class StockIssueAccessory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['stock_issue_id', 'accessory_id', 'quantity'];

    protected static function newFactory()
    {
        //return StockIssueAccessoryFactory::new();
    }
    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }
}
