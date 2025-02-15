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
            return $user->user_details->status !== 'Inactive';
        });


    }
}
