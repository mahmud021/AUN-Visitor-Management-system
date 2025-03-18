<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Check if user has permission to view all visitors.
        $canViewAll = Gate::allows('view-all-visitors', $user);

        // Daily visitor count.
        $dailyVisitorCount = $canViewAll
            ? Visitor::whereDate('created_at', Carbon::today())->count()
            : $user->visitors()->whereDate('created_at', Carbon::today())->count();

        // Checked-in visitor count.
        $checkedInVisitorCount = $canViewAll
            ? Visitor::where('status', 'checked_in')->count()
            : $user->visitors()->where('status', 'checked_in')->count();

        // Overstaying visitors count and list.
        $overstayingVisitors = $canViewAll
            ? Visitor::where('status', 'checked_in')
                ->where('end_time', '<', Carbon::now())
                ->get()
            : $user->visitors()->where('status', 'checked_in')
                ->where('end_time', '<', Carbon::now())
                ->get();

        $overstayingVisitorCount = $overstayingVisitors->count();

        // Data to pass to the view.
        $data = [
            'user' => $user,
            'myVisitors' => $this->getUserVisitors($user),  // Always shows user's own visitors.
            'dailyVisitorCount' => $dailyVisitorCount,
            'checkedInVisitorCount' => $checkedInVisitorCount,
            'overstayingVisitorCount' => $overstayingVisitorCount,
            'overstayingVisitors' => $overstayingVisitors, // Pass the overstaying visitors collection
            'checkedInVisitors' => $canViewAll
                ? Visitor::where('status', 'checked_in')->get()
                : $user->visitors()->where('status', 'checked_in')->get(),
        ];

        // Add all visitors if user has permission.
        if ($canViewAll) {
            $data['allVisitors'] = $this->getAllVisitors();
        }

        return view('dashboard', $data);
    }
    // Get authenticated user's visitors.
    protected function getUserVisitors(User $user)
    {
        return $user->visitors()
            ->with('user')
            ->latest()
            ->simplePaginate(8, ['*'], 'myVisitorsPage');
    }

    // Get all visitors (only for authorized users).
    protected function getAllVisitors()
    {
        return Visitor::with('user')
            ->latest()
            ->simplePaginate(8, ['*'], 'allVisitorsPage');
    }
}
