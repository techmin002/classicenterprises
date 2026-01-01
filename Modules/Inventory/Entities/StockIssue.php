<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\Database\factories\StockIssueFactory;

class StockIssue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'message',
        'requested_by',
        'status',
    ];

    protected static function newFactory()
    {
        // return StockIssueFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function machineries()
    {
        return $this->hasMany(StockIssueMachinery::class);
    }

    public function accessories()
    {
        return $this->hasMany(StockIssueAccessory::class);
    }

    public function technicalTools()
    {
        return $this->hasMany(StockIssueTechnicalTool::class);
    }

    public function stockTransfers()
    {
        return $this->hasMany(StockTransfer::class, 'stock_issue_id');
    }
}
