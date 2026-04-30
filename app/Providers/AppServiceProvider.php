<?php

namespace App\Providers;

use App\Models\LDemo;
use Illuminate\Support\Facades\View;
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
        View::composer(['welcome' , 'demo1'], function ($view) {
            $ldemos = LDemo::all();
            $view->with('demos', $ldemos);
        });
    }
}
