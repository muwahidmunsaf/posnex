<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_code',
        'created_by',
        'subtotal',
        'total_amount',
        'tax_percentage',
        'tax_amount',
        'payment_method',
        'discount',
        'company_id',
        'customer_id',
        'customer_name', // For retail customer name
        'sale_type',
        'amount_received',
        'change_return',
    ];

    public function inventorySales()
    {
        return $this->hasMany(InventorySale::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function returns()
    {
        return $this->hasMany(ReturnTransaction::class);
    }
}
