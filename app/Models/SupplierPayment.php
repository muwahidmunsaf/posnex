<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'amount',
        'payment_date',
        'payment_method',
        'note',
        'currency_code',
        'exchange_rate_to_pkr',
        'pkr_amount',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
