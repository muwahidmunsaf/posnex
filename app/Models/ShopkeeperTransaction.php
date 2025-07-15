<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopkeeperTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'shopkeeper_id',
        'distributor_id',
        'inventory_id',
        'type',
        'quantity',
        'unit_price',
        'total_amount',
        'commission_amount',
        'transaction_date',
        'description',
        'status'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'commission_amount' => 'decimal:2'
    ];

    public function shopkeeper()
    {
        return $this->belongsTo(Shopkeeper::class);
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
