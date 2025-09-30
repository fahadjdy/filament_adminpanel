<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\View;


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
        $profile = CompanyProfile::first();
        View::share('profile', $profile);
    }
}
