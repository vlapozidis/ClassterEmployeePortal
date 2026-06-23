<?php

namespace App\Providers;

use App\Models\LeaveRequest;
use App\Policies\LeaveRequestPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;

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
        Gate::policy(LeaveRequest::class, LeaveRequestPolicy::class);

        // Register Microsoft Entra ID provider with Socialite
        Socialite::extend('microsoft', function ($app) {
            $config = $app['config']['services.microsoft'];
            return Socialite::buildProvider(
                MicrosoftAzureProvider::class,
                $config
            );
        });
    }
}
