<?php

namespace Modules\Lead\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadResponse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lead_id',
        'branch_id',
        'created_by',
        'followups',
        'message',
        'deleted_at'
    ];
    public function lead(){
        return $this->belongsTo(Lead::class,'lead_id','id');
    }
    protected static function newFactory()
    {
        return \Modules\Lead\Database\factories\LeadResponseFactory::new();
    }
}
