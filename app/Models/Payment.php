<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'amount_paid',
        'amount_due',
        'date',
        'note',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
} 