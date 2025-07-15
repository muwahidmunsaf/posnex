<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalSale extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'saleE_id',
        'purchaseE_id',
        'sale_amount',
        'payment_method',
        'tax_amount',
        'total_amount',
        'created_by',
        'company_id',
        'customer_id',
        'parent_sale_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function purchase()
    {
        return $this->belongsTo(ExternalPurchase::class, 'purchaseE_id', 'purchaseE_id');
    }
}
