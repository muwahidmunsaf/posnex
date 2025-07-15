<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'item_name',
        'retail_amount',
        'wholesale_amount',
        'details',
        'unit',
        'barcode',
        'sku',
        'supplier_id',
        'category_id',
        'status',
        'image',
        'company_id',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function inventorySales()
    {
        return $this->hasMany(InventorySale::class, 'item_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getUnitSoldAttribute()
    {
        return $this->inventorySales()->sum('quantity');
    }
}
