<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'inventory_id',
        'quantity',
        'purchase_amount',
        'company_id',
    ];

    // Relationships
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
