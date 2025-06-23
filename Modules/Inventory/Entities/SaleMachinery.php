<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleMachinery extends Model
{
    use HasFactory;

     protected $table = 'sales_machineries';

    protected $fillable = [
        'sale_id',
        'machinery_id',
        'name',
        'quantity',
        'price',
        'total',
        'warranty'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function machinery()
    {
        return $this->belongsTo(Machineries::class);
    }

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\SaleMachineryFactory::new();
    }
}