<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnTransaction extends Model
{
    protected $fillable = [
        'sale_id',
        'item_id',
        'quantity',
        'amount',
        'reason',
        'processed_by',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function item()
    {
        return $this->belongsTo(Inventory::class, 'item_id');
    }
}
