<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
                    'name',
                    'gender',
                    'birthday',
                    'nid',
                    'address',
                    'photo',
                    'branch_id',
                    'designation',
                    'phone',
                    'salary',
                    'eSalaryAcc',
                    'payLeave',
                    'npayLeave',
                    'evmoSalarydate',
                    'status',
                    'joinDate',
                    'joinTime',
                    'author', 
                             ];

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id');
        }
}

