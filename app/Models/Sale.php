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
        'distributor_id',
        'shopkeeper_id',
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

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
    public function shopkeeper()
    {
        return $this->belongsTo(Shopkeeper::class);
    }

    public function manualProducts()
    {
        return $this->hasMany(\App\Models\ExternalSale::class, 'parent_sale_id');
    }
}
