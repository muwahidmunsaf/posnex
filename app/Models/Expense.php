<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

    use HasFactory;

    protected $fillable = [
        'purpose',
        'details',
        'amount',
        'paidBy',
        'paymentWay',
        'company_id'
    ];

    /**
     * The company this customer belongs to.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
