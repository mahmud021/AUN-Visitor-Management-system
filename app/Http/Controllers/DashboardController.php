<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        $user        = auth()->user();
        $canViewAll  = Gate::allows('view-all-visitors', $user);   // ability check


        // “Today” filter
        $todayFilter = fn ($q) => $q->whereDate('created_at', Carbon::today());

        $dailyVisitorCount    = $this->scope($user, $canViewAll)
            ->when(true, $todayFilter)
            ->count();

        $totalVisitorsToday   = $this->scope($user, $canViewAll)
            ->when(true, $todayFilter)
            ->get();

        $checkedInVisitorCount = $this->scope($user, $canViewAll)
            ->where('status', 'checked_in')
            ->count();

        $overstayingVisitors   = $this->scope($user, $canViewAll)
            ->where('status', 'checked_in')
            ->where('end_time', '<', Carbon::now())
            ->get();

        /* ─────────────── 2.  Paginated tab data ─────────────── */

        // collections you already had
        $myVisitors        = $this->paginatedVisitors($user, false);              // always
        $checkedInVisitors = $this->paginatedVisitors($user, $canViewAll, 'checked_in');

        // only admins / HR see global lists
        $allVisitors       = $canViewAll ? $this->paginatedVisitors($user, true)                 : collect();
        $pendingVisitors   = $canViewAll ? $this->paginatedVisitors($user, true, 'pending')      : collect();
        $approvedVisitors  = $canViewAll ? $this->paginatedVisitors($user, true, 'approved')     : collect();
        $checkedOutVisitors= $canViewAll ? $this->paginatedVisitors($user, true, 'checked_out')  : collect();

        /* ─────────────── 3.  Push everything to the view ─────── */

        return view('dashboard', [
            'user'                    => $user,
            'locations'               => Location::all(),

            // tab collections
            'myVisitors'              => $myVisitors,
            'allVisitors'             => $allVisitors,
            'pendingVisitors'         => $pendingVisitors,
            'approvedVisitors'        => $approvedVisitors,
            'checkedInVisitors'       => $checkedInVisitors,
            'checkedOutVisitors'      => $checkedOutVisitors,

            // KPI / badge numbers
            'dailyVisitorCount'       => $dailyVisitorCount,
            'totalVisitors'           => $totalVisitorsToday,
            'checkedInVisitorCount'   => $checkedInVisitorCount,
            'overstayingVisitors'     => $overstayingVisitors,
            'overstayingVisitorCount' => $overstayingVisitors->count(),
        ]);
    }

    /* ───────────────────────── Helpers ───────────────────────── */

    /**
     * Get a single paginated slice (by status) respecting permissions.
     */
    protected function paginatedVisitors(User $user, bool $canViewAll, string $status = null)
    {
        $query = $this->scope($user, $canViewAll);

        if ($status) {
            $query->where('status', $status);
        }

        // Make the page name unique so each tab paginates independently
        $pageName = $status ? "{$status}Page" : 'visitorsPage';

        return $query->with('user')
            ->latest()
            ->simplePaginate(8, ['*'], $pageName);
    }

    /**
     * Apply “my visitors” vs “all visitors” scope in one place.
     */
    protected function scope(User $user, bool $canViewAll)
    {
        return $canViewAll ? Visitor::query() : $user->visitors();
    }

}
