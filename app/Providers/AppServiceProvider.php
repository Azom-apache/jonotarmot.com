<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Kreait\Firebase\Factory;
// use Kreait\Firebase\ServiceAccount;
use Illuminate\Support\Facades\View; // Make sure to import the View facade
use Illuminate\Support\Facades\Auth;
use App\Http\ViewComposers\AuthComposer;
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
        if (Auth::check()) {
            View::composer('*', AuthComposer::class);
        }
        
        view()->share('countries', getCountries());
        view()->share('languages', getLanguages());
          \Illuminate\Support\Facades\Schema::defaultStringLength(191);
    }
}
