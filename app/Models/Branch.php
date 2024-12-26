<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'address',
        'total_values',
        'status',
    ];

    public function employees(){
        return $this->hasMany(Employee::class, 'branch_id');
        }
}
