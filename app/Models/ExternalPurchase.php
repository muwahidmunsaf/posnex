<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalPurchase extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'purchaseE_id',
        'item_name',
        'details',
        'purchase_amount',
        'purchase_source',
        'created_by',
        'company_id',
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
}
