<?php

namespace Modules\Pettycash\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;
use Modules\Pettycash\Database\factories\PettyCashRequestFactory;

class PettyCashRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
    'branch_id',
    'title',
    'amount',
    'date',
    'month',
    'description',
    'slug',
];

    protected static function newFactory(): PettyCashRequestFactory
    {
        //return PettyCashRequestFactory::new();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function getMonthNameAttribute()
    {
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];
        return $months[$this->month] ?? 'N/A';
    }
}
