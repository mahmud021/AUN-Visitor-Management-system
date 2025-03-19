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
        // Existing gate: allows Security, super admin, HR Admin for visitor management.
        Gate::define('view-all-visitors', function ($user) {
            return in_array($user->user_details->role, ['Security', 'super admin', 'HR Admin']);
        });

        Gate::define('update-visitor', function ($user, $visitor) {
            // Super admin and HR Admin can update any visitor record.
            if (in_array($user->user_details->role, ['HR Admin', 'super admin'])) {
                return true;
            }

            // For all other users:
            // If the visitor is already checked in, disallow updating.
            if ($visitor->status === 'checked_in') {
                return false;
            }

            // Otherwise, allow update if the visitor belongs to the user.
            return $visitor->user_id === $user->id;
        });




        Gate::define('create-visitor', function ($user) {
            if (!$user->relationLoaded('user_details')) {
                $user->load('user_details');
            }
            // Deny access if the user's role is 'security'
            if ($user->user_details->role === 'Security') {
                return false;
            }
            return $user->user_details && !$user->user_details->blacklist;
        });


        // New gate: only allow super admin and HR Admin to access user management routes.
        Gate::define('view-users', function ($user) {
            return in_array($user->user_details->role, ['super admin', 'HR Admin']);
        });
    }
}
