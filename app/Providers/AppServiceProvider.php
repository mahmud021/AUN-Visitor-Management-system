<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
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
        // Define a gate to check if the user is a security officer or super admin
        Gate::define('view-all-visitors', function ($user) {
            // Check if the user has one of the allowed roles
            return in_array($user->user_details->role, ['Security', 'super admin','HR Admin']);
        });

        Gate::define('create-visitor', function ($user) {
            // Ensure relationship is loaded
            if (!$user->relationLoaded('user_details')) {
                $user->load('user_details');
            }

            // Deny if blacklisted or missing user details
            return $user->user_details && !$user->user_details->blacklist;
        });


    }
}
