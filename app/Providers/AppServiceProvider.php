<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // FIX: Force HTTPS in production to prevent Mixed Content CSS blocking
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}