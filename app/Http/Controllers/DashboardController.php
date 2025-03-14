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

        // Filter visitors for the current user by status
        $approvedVisitorsList = Visitor::where('user_id', $user->id)
            ->where('status', 'approved')
            ->get();

        $checkedInVisitors = Visitor::where('user_id', $user->id)
            ->where('status', 'checked_in')
            ->get();


        $checkedOutVisitors = Visitor::where('user_id', $user->id)
            ->where('status', 'checked_out')
            ->get();

        return view('dashboard', [
            'user'                  => $user,
            'myVisitors'            => $this->getUserVisitors($user),
            'allVisitors'           => $this->getAllVisitors(),
            'approvedVisitorsList'  => $approvedVisitorsList,
            'checkedInVisitors'     => $checkedInVisitors,
            'checkedOutVisitors'    => $checkedOutVisitors,
        ]);
    }


    // Shared Query Methods

    protected function getUserVisitors(User $user)
    {
        return Visitor::where('user_id', $user->id)
            ->with('user')
            ->latest()
            ->simplePaginate(8, ['*'], 'userVisitorsPage');
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
            ->filter(function ($visitor) {
                return $visitor->timelineEvents()
                        ->latest('occurred_at')
                        ->first()?->event_type === 'checked_in';
            })
            ->count();
    }
}
