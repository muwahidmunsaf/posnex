<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'salary',
        'contact',
        'address',
        'company_id',
    ];

    public function salaryPayments()
    {
        return $this->hasMany(SalaryPayment::class);
    }
} 