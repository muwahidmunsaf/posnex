<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributorPayment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'distributor_id',
        'amount',
        'type',
        'description',
        'payment_date',
        'status',
        'reference_no',
        'expense_id',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
