<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate; // Add this

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Existing daily visitor count (example)
        $dailyVisitorCount = Gate::allows('view-all-visitors', $user)
            ? Visitor::whereDate('created_at', Carbon::today())->count()
            : Visitor::where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();

        // New checked-in visitor count
        $checkedInVisitorCount = Gate::allows('view-all-visitors', $user)
            ? Visitor::where('status', 'checked_in')->count()
            : Visitor::where('user_id', $user->id)->where('status', 'checked_in')->count();

        // Data to pass to the view
        $data = [
            'user' => $user,
            'myVisitors' => $this->getUserVisitors($user),
            'dailyVisitorCount' => $dailyVisitorCount,
            'checkedInVisitorCount' => $checkedInVisitorCount,
        ];

        // Add all visitors if user has permission (example)
        if (Gate::allows('view-all-visitors', $user)) {
            $data['allVisitors'] = $this->getAllVisitors();
        }

        return view('dashboard', $data);
    }

    // Example method to get user's visitors (assumed existing)
    protected function getUserVisitors(User $user)
    {
        $query = Visitor::with('user')->latest();
        if (!Gate::allows('view-all-visitors', $user)) {
            $query->where('user_id', $user->id);
        }
        return $query->simplePaginate(8, ['*'], 'myVisitorsPage');
    }

    // Example method to get all visitors (assumed existing)
    protected function getAllVisitors()
    {
        return Visitor::latest()->simplePaginate(8, ['*'], 'allVisitorsPage');
    }

}
