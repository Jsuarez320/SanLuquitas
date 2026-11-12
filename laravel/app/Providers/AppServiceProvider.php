<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Port de LOGIN_RATE_LIMIT de SmartPark: 5 intentos cada 15 minutos por IP.
        RateLimiter::for('admin-login', fn (Request $request) => Limit::perMinutes(1, 5)->by($request->ip()));
    }
}
