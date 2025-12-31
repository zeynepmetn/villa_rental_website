<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use App\Models\Location;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        
        // Share locations with all views
        View::composer('*', function ($view) {
            $view->with('globalLocations', Location::orderBy('name')->get());
        });
        
        // Share user roles with admin views
        View::composer(['admin.*', 'realtor.*'], function ($view) {
            if (auth()->check()) {
                $view->with('authUser', auth()->user());
            }
        });
    }
}
