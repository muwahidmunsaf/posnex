<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Distributor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'phone', 'address', 'commission_rate', 'company_id'];

    public function shopkeepers()
    {
        return $this->hasMany(Shopkeeper::class);
    }

    public function payments()
    {
        return $this->hasMany(DistributorPayment::class);
    }

    public function products()
    {
        return $this->hasMany(DistributorProduct::class);
    }

    public function transactions()
    {
        return $this->hasMany(ShopkeeperTransaction::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Calculate total outstanding balance
    public function getOutstandingBalanceAttribute()
    {
        $totalProductsValue = $this->products()->where('status', 'active')->sum('total_value');
        $totalPayments = $this->payments()->where('status', 'completed')->sum('amount');
        return $totalProductsValue - $totalPayments;
    }

    // Calculate total commission earned
    public function getTotalCommissionAttribute()
    {
        // Sum commission from both product_sold and payment_made
        return $this->transactions()->whereIn('type', ['product_sold', 'payment_made'])->sum('commission_amount');
    }

    // Calculate total sales for all shopkeepers under this distributor
    public function getTotalSalesAttribute()
    {
        $shopkeeperIds = $this->shopkeepers()->pluck('id');
        $salesTotal = \App\Models\Sale::whereIn('shopkeeper_id', $shopkeeperIds)->sum('total_amount');
        $openingOutstanding = \App\Models\ShopkeeperTransaction::whereIn('shopkeeper_id', $shopkeeperIds)
            ->where('type', 'product_sold')
            ->where('description', 'Opening Outstanding')
            ->sum('total_amount');
        return $salesTotal + $openingOutstanding;
    }
}
