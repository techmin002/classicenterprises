<?php

namespace Modules\Branch\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Employee\Entities\Employee;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // add fields you need

    public function users()
    {
        return $this->hasMany(User::class, 'branch_id', 'id');
    }

    public function admins()
    {
        return $this->hasMany(User::class, 'branch_id', 'id')
                    ->where('access_type', 'Admin');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'branch_id', 'id');
    }
}

