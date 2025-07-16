<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'cel_no',
        'email',
        'cnic',
        'address',
        'city',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sales()
    {
        return $this->hasMany(\App\Models\Sale::class);
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }

    public function getOutstandingBalanceAttribute()
    {
        // Total sales for this customer
        $totalSales = $this->sales()->sum('total_amount');
        // Total returns for this customer
        $totalReturns = 0;
        foreach ($this->sales as $sale) {
            $totalReturns += $sale->returns->sum(function($ret) { return $ret->amount * $ret->quantity; });
        }
        // Total payments made by this customer
        $totalPaid = $this->payments()->sum('amount_paid') + $this->sales()->sum('amount_received');
        // Outstanding = (sales - returns) - paid
        return ($totalSales - $totalReturns) - $totalPaid;
    }
}
