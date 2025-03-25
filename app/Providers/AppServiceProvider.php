<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;



class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }
    public function boot()
    {
        view()->composer('*', function ($view) {
            $role = auth()->check() ? auth()->user()->role : null;
            $view->with('role', $role);
        });
    }
}