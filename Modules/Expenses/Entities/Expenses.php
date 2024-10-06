<?php

namespace Modules\Expenses\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Expenses extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded=[];
    protected $fillable = [];

    
    protected static function newFactory()
    {
        return \Modules\Expenses\Database\factories\ExpensesFactory::new();
    }
}
