<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate; // Add this

class DashboardController extends Controller
{
    // Add middleware in constructor to ensure authenticated access


    // Main Dashboard View
    public function index()
    {
        $user = auth()->user();

        // Prepare data based on user permissions
        $data = [
            'user' => $user,
            'myVisitors' => $this->getUserVisitors($user),
        ];

        // Only include allVisitors if user has permission
        if (Gate::allows('view-all-visitors', $user)) {
            $data['allVisitors'] = $this->getAllVisitors();
        }

        return view('dashboard', $data);
    }

    // Shared Query Methods
    protected function getUserVisitors(User $user)
    {
        // Ensure user can only see their own visitors unless they have higher privileges
        $query = Visitor::with('user')->latest();

        if (!Gate::allows('view-all-visitors', $user)) {
            $query->where('user_id', $user->id);
        }

        return $query->simplePaginate(8, ['*'], 'allVisitorsPage');
    }

    protected function getAllVisitors()
    {
        // This method will only be called if user has view-all-visitors permission
        return Visitor::latest()
            ->simplePaginate(8, ['*'], 'allVisitorsPage');
    }
}
