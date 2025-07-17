<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shopkeeper extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['distributor_id', 'name', 'phone', 'address'];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function transactions()
    {
        return $this->hasMany(ShopkeeperTransaction::class);
    }

    public function getCompanyAttribute()
    {
        return $this->distributor && $this->distributor->company ? $this->distributor->company : null;
    }

    // Calculate total sales
    public function getTotalSalesAttribute()
    {
        // Use sales table for total sales
        return \App\Models\Sale::where('shopkeeper_id', $this->id)->sum('total_amount');
    }

    // Calculate outstanding balance
    public function getOutstandingBalanceAttribute()
    {
        // Outstanding = (total sales + opening outstanding) - total payments received
        $totalSales = \App\Models\Sale::where('shopkeeper_id', $this->id)->sum('total_amount');
        $openingOutstanding = $this->transactions()->where('type', 'product_sold')->where('description', 'Opening Outstanding')->sum('total_amount');
        $totalPayments = $this->transactions()->where('type', 'payment_made')->sum('total_amount');
        return $totalSales + $openingOutstanding - $totalPayments;
    }
}
