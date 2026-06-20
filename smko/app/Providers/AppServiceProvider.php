<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL; // <-- Tambahkan baris ini

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
        // Pengaturan pagination Anda tetap dipertahankan
        Paginator::useBootstrapFive();

        // Memaksa semua URL menggunakan HTTPS jika berjalan di Railway (production)
        if (config('app.env') === 'production' || env('RAILWAY_ENVIRONMENT')) {
            URL::forceScheme('https');
        }
    }
}