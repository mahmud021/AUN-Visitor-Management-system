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

        Gate::define('update-inventory', function ($user, $inventory) {
            // Super admin, HR Admin, and Security roles can update any inventory record.
            if (in_array($user->user_details->role, ['HR Admin', 'super admin', 'security'])) {
                return true;
            }
            // For all other users:
            // If the inventory item is already checked in, disallow updating.
            if ($inventory->status === 'checked_in') {
                return false;
            }
            // Otherwise, allow update only if the inventory belongs to the user.
            return $inventory->user_id === $user->id;
        });


        Gate::define('override-visitor-creation', function ($user) {
            return in_array($user->user_details->role, ['HR Admin', 'super admin']);
        });


        Gate::define('view-timeline', function ($user, $visitor) {
            // HR Admin, Super Admin, and Security can view any timeline.
            if (in_array($user->user_details->role, ['HR Admin', 'super admin', 'Security'])) {
                return true;
            }
            // Regular users (student/staff) can only view the timeline if the visitor belongs to them.
            return $visitor->user_id === $user->id;
        });

        Gate::define('view-profile', function ($currentUser, $profileUser) {
            // Allow if they’re looking at their own profile...
            if ($currentUser->id === $profileUser->id) {
                return true;
            }
            // ...or if the user is HR Admin, Super Admin, or Security.
            return in_array($currentUser->user_details->role, ['HR Admin', 'super admin', 'Security']);
        });

        Gate::define('create-visitor', function ($user) {
            if (!$user->relationLoaded('user_details')) {
                $user->load('user_details');
            }

            // Super admin or HR Admin bypass all restrictions.
            if (in_array($user->user_details->role, ['super admin', 'HR Admin'])) {
                return true;
            }

            // Deny if the user's role is 'Security'
            if ($user->user_details->role === 'Security') {
                return false;
            }

            // Deny if the user is blacklisted.
            if ($user->user_details->blacklist) {
                return false;
            }

            // Check the time window.
            $settings = \App\Models\AppSetting::first();
            if ($settings) {
                $start = \Carbon\Carbon::parse($settings->visitor_start_time);
                $end   = \Carbon\Carbon::parse($settings->visitor_end_time);
                $now   = \Carbon\Carbon::now();
                // Deny if the current time is not within the allowed range.
                if (!$now->between($start, $end)) {
                    return false;
                }
            }

            return true;
        });

        Gate::define('check-in-visitor', function ($user, $visitor) {
            // Super admin or HR Admin bypass time restrictions
            if (in_array($user->user_details->role, ['super admin', 'HR Admin'])) {
                return true;
            }

            // Only allow security users to check in visitors
            if ($user->user_details->role !== 'Security') {
                return false;
            }

            // Retrieve the time window from settings
            $settings = \App\Models\AppSetting::first();
            if ($settings) {
                $start = \Carbon\Carbon::parse($settings->visitor_start_time);
                $end   = \Carbon\Carbon::parse($settings->visitor_end_time);
                $now   = \Carbon\Carbon::now();
                // Security users can only check in if current time is within allowed time window
                if (!$now->between($start, $end)) {
                    return false;
                }
            }

            return true;
        });


        Gate::define('view-inventory', function ($user) {
            return in_array($user->user_details->role, ['HR Admin', 'Security', 'super admin']);
        });
        Gate::define('access-settings', function ($user) {
            return in_array($user->user_details->role, ['HR Admin', 'super admin']);
        });




        // New gate: only allow super admin and HR Admin to access user management routes.
        Gate::define('view-users', function ($user) {
            return in_array($user->user_details->role, ['super admin', 'HR Admin']);
        });
    }
}
