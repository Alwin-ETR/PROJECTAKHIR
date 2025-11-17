<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MahasiswaMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register middleware manually
        $this->app->singleton('admin', function ($app) {
            return new AdminMiddleware;
        });
        
        $this->app->singleton('mahasiswa', function ($app) {
            return new MahasiswaMiddleware;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}