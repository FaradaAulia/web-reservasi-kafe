<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- 1. Pastikan class URL di-import di atas

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
        // 2. Tambahkan baris ini untuk memaksa HTTPS di lingkungan production (Railway)
        if (config('app.env') === 'production' || app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}