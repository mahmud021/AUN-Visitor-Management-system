<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Main Dashboard View
    public function index()
    {
        $user = auth()->user();

        return view('dashboard', [
            'user' => $user,
            'myVisitors' => $this->getUserVisitors($user),
            'allVisitors' => $this->getAllVisitors(),
            'expectedVisitors' => $this->getExpectedVisitorsCount($user),
            'checkedInCount' => $this->getCheckedInCount(),
            'checkedOutCount' => $this->getCheckedOutCount(),
            'onCampusCount' => $this->getOnCampusCount()
        ]);
    }

    // Shared Query Methods
    protected function getUserVisitors(User $user)
    {
        return Visitor::with('user') // Add this
        ->latest()
            ->simplePaginate(8, ['*'], 'allVisitorsPage');

    }

    protected function getAllVisitors()
    {
        return Visitor::latest()
            ->simplePaginate(8, ['*'], 'allVisitorsPage');
    }

    protected function getExpectedVisitorsCount(User $user): int
    {
        return DB::table('timeline_events')
            ->join('visitors', 'timeline_events.visitor_id', '=', 'visitors.id')
            ->where('timeline_events.event_type', 'approved')
            ->whereDate('timeline_events.occurred_at', Carbon::today())
            ->where('visitors.user_id', $user->id)
            ->distinct('timeline_events.visitor_id')
            ->count('timeline_events.visitor_id');
    }

    protected function getCheckedInCount(): int
    {
        return DB::table('timeline_events')
            ->where('event_type', 'checked_in')
            ->whereDate('occurred_at', Carbon::today())
            ->distinct('visitor_id')
            ->count('visitor_id');
    }

    protected function getCheckedOutCount(): int
    {
        return DB::table('timeline_events')
            ->where('event_type', 'checked_out')
            ->whereDate('occurred_at', Carbon::today())
            ->distinct('visitor_id')
            ->count('visitor_id');
    }

    protected function getOnCampusCount(): int
    {
        return Visitor::whereHas('timelineEvents', function ($query) {
            $query->whereDate('occurred_at', Carbon::today())
                ->whereIn('event_type', ['checked_in', 'checked_out']);
        })
            ->get()
            ->filter(fn ($visitor) => $visitor->timelineEvents()
                    ->latest('occurred_at')
                    ->first()?->event_type === 'checked_in'
            )
            ->count();
    }

    // User-Specific Count Methods
    protected function getCheckedInCountForUser(User $user): int
    {
        return $user->visitors()
            ->where('status', 'checked_in')
            ->count();
    }

    protected function getOnCampusCountForUser(User $user): int
    {
        return $user->visitors()
            ->where('status', 'checked_in')
            ->count();
    }

    protected function getCheckedOutCountForUser(User $user): int
    {
        return $user->visitors()
            ->where('status', 'checked_out')
            ->count();
    }
}
