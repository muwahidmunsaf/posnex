<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\DistributorPayment;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            require base_path('routes/web.php');
            require base_path('routes/api.php');
        });

        // Explicit model binding for distributorPayment
        Route::bind('distributorPayment', function ($value) {
            return DistributorPayment::findOrFail($value);
        });
    }
} 