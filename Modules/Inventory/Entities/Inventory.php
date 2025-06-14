<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'machinery_id', 'accessory_id', 'branch_id', 'quantity', 'opening_quantity', 'updated_by', 'status',
    ];
}
