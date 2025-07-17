<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_name',
        'cell_no',
        'tel_no',
        'contact_person',
        'email',
        'address',
        'company_id',
        'country', // added for country selection
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function purchases()
    {
        return $this->hasMany(\App\Models\Purchase::class);
    }
    public function supplierPayments()
    {
        return $this->hasMany(\App\Models\SupplierPayment::class);
    }

    public function payments()
    {
        return $this->supplierPayments();
    }

    public function getCurrencyAttribute()
    {
        $currencies = [
            'Pakistan' => ['symbol' => 'Rs', 'code' => 'PKR'],
            'United States' => ['symbol' => '$', 'code' => 'USD'],
            'United Kingdom' => ['symbol' => '£', 'code' => 'GBP'],
            'China' => ['symbol' => '¥', 'code' => 'CNY'],
            'India' => ['symbol' => '₹', 'code' => 'INR'],
            'UAE' => ['symbol' => 'د.إ', 'code' => 'AED'],
            'Saudi Arabia' => ['symbol' => '﷼', 'code' => 'SAR'],
            'Turkey' => ['symbol' => '₺', 'code' => 'TRY'],
            'Afghanistan' => ['symbol' => '؋', 'code' => 'AFN'],
            'Bangladesh' => ['symbol' => '৳', 'code' => 'BDT'],
            'Thailand' => ['symbol' => '฿', 'code' => 'THB'],
        ];
        return $currencies[$this->country] ?? ['symbol' => '$', 'code' => 'USD'];
    }

    public static function getCurrencyRateToPKR($currencyCode)
    {
        if ($currencyCode === 'PKR') {
            return 1.0;
        }
        try {
            $response = \Illuminate\Support\Facades\Http::get("https://open.er-api.com/v6/latest/{$currencyCode}");
            if ($response->ok() && isset($response['rates']['PKR']) && is_numeric($response['rates']['PKR']) && $response['rates']['PKR'] != 1.0) {
                return (float) $response['rates']['PKR'];
            }
            // Fallback: via USD
            $usdResp = \Illuminate\Support\Facades\Http::get("https://open.er-api.com/v6/latest/USD");
            $curResp = \Illuminate\Support\Facades\Http::get("https://open.er-api.com/v6/latest/{$currencyCode}");
            $usdToPkr = $usdResp->ok() && isset($usdResp['rates']['PKR']) && is_numeric($usdResp['rates']['PKR']) ? (float) $usdResp['rates']['PKR'] : null;
            $currencyToUsd = $curResp->ok() && isset($curResp['rates']['USD']) && is_numeric($curResp['rates']['USD']) ? (float) $curResp['rates']['USD'] : null;
            if ($usdToPkr && $currencyToUsd && $currencyToUsd != 0) {
                $rate = $usdToPkr / $currencyToUsd;
                return (float) $rate;
            }
        } catch (\Exception $e) {
            // Ignore and fallback
        }
        return 1.0;
    }
}
