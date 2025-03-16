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
        // Define roles that can view all visitors
        Gate::define('view-all-visitors', function ($user) {
            $allowedRoles = ['Security', 'super admin', 'HR Admin'];
            $user->loadMissing('user_details'); // Ensure relation is loaded
            return $user->user_details && in_array($user->user_details->role, $allowedRoles);
        });

        // Define who can create visitors
        Gate::define('create-visitor', function ($user) {
            $user->loadMissing('user_details');
            return $user->user_details && !$user->user_details->blacklist;
        });

        // Define who can manage users
        Gate::define('view-users', function ($user) {
            $allowedRoles = ['super admin', 'HR Admin'];
            $user->loadMissing('user_details');
            return $user->user_details && in_array($user->user_details->role, $allowedRoles);
        });
    }
}
