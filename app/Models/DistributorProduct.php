<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DistributorProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'distributor_id',
        'inventory_id',
        'quantity_assigned',
        'quantity_remaining',
        'unit_price',
        'total_value',
        'assignment_date',
        'status',
        'notes',
        'assignment_number'
    ];

    protected $casts = [
        'assignment_date' => 'date',
        'unit_price' => 'decimal:2',
        'total_value' => 'decimal:2'
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
