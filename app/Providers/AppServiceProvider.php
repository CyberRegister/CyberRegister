<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Laravel used to fall back to the login route when an unauthenticated
        // request had no redirect target. That fallback is gone, and without a
        // target the handler answers with an empty 401 instead of redirecting.
        Authenticate::redirectUsing(fn () => route('login'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}
