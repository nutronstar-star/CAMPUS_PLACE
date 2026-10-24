<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // FIX: rules S1 - min 6 chars, 1 uppercase, 1 number
        Password::defaults(function () {
            return Password::min(6)->mixedCase()->numbers();
        });
    }
}
