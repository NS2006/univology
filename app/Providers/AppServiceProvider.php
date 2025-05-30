<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->role->name === 'admin';
        });

        Blade::if('lecturer', function () {
            return auth()->check() && auth()->user()->role->name === 'lecturer';
        });

        Blade::if('student', function () {
            return auth()->check() && auth()->user()->role->name === 'student';
        });

        Blade::if('user', function () {
            return auth()->check() && auth()->user()->role->name === 'student' || auth()->check() && auth()->user()->role->name === 'lecturer';
        });
    }
}
