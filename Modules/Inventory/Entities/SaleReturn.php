<?php
namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\Entities\SaleReturnItem;  
use Modules\Inventory\Entities\User;

class SaleReturn extends Model
{

    protected $fillable = [
        'sale_id',
        'return_invoice',
        'total_return_amount',
        'remarks',
        'created_by'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function items()
    {
        return $this->hasMany(SaleReturnItem::class);
    }
    public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}
}