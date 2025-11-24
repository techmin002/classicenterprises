<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Branch\Entities\Branch;

class Log extends Model
{
    use HasFactory;
    protected $table='logs';
    protected $fillable=[
        'user_id',
        'perform',
        'log_date',
        'status',
        'url',
        'type',
        'branch_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
