<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $canViewAll = Gate::allows('view-all-visitors', $user);

        // Cache locations since they probably don't change often
        $locations = Cache::remember('locations', now()->addHours(6), function () {
            return Location::all();
        });

        // Base query with eager loading
        $baseQuery = $this->scope($user, $canViewAll)
            ->with(['user.user_details']); // Eager load user and their details

        // Today's filter closure
        $todayFilter = fn ($q) => $q->whereDate('created_at', Carbon::today());

        // Get all metrics in a single query where possible
        $todayQuery = (clone $baseQuery)->when(true, $todayFilter);

        $dailyVisitorCount = $todayQuery->count();
        $totalVisitorsToday = $todayQuery->get();

        $checkedInQuery = (clone $baseQuery)
            ->where('status', 'checked_in');

        $checkedInVisitorCount = $checkedInQuery->count();
        $overstayingVisitors = $checkedInQuery->where('end_time', '<', Carbon::now())->get();

        /* ─────────────── Paginated tab data ─────────────── */
        $myVisitors = $this->paginatedVisitors($user, false);
        $pendingVisitors = $this->paginatedVisitors($user, $canViewAll, 'pending');
        $approvedVisitors = $this->paginatedVisitors($user, $canViewAll, 'approved');
        $checkedInVisitors = $this->paginatedVisitors($user, $canViewAll, 'checked_in');
        $checkedOutVisitors = $this->paginatedVisitors($user, $canViewAll, 'checked_out');

        $allVisitors = $canViewAll ? $this->paginatedVisitors($user, true) : collect();

        return view('dashboard', [
            'user' => $user,
            'locations' => $locations,

            // tab collections
            'myVisitors' => $myVisitors,
            'allVisitors' => $allVisitors,
            'pendingVisitors' => $pendingVisitors,
            'approvedVisitors' => $approvedVisitors,
            'checkedInVisitors' => $checkedInVisitors,
            'checkedOutVisitors' => $checkedOutVisitors,

            // KPI / badge numbers
            'dailyVisitorCount' => $dailyVisitorCount,
            'totalVisitors' => $totalVisitorsToday,
            'checkedInVisitorCount' => $checkedInVisitorCount,
            'overstayingVisitors' => $overstayingVisitors,
            'overstayingVisitorCount' => $overstayingVisitors->count(),
        ]);
    }

    protected function paginatedVisitors(User $user, bool $canViewAll, string $status = null)
    {
        $query = $this->scope($user, $canViewAll)
            ->with(['user.user_details']); // Eager load here too

        if ($status) {
            $query->where('status', $status);
        }

        $pageName = $status ? "{$status}Page" : 'visitorsPage';

        return $query->latest()->simplePaginate(8, ['*'], $pageName);
    }

    protected function scope(User $user, bool $canViewAll)
    {
        return $canViewAll ? Visitor::query() : $user->visitors();
    }
}
