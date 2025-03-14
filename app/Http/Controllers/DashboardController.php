<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitor;

class DashboardController extends Controller
{
    // Main Dashboard View
    public function index()
    {
        $user = auth()->user();

        return view('dashboard', [
            'user'       => $user,
            'myVisitors' => $this->getUserVisitors($user),
            'allVisitors'=> $this->getAllVisitors(),
        ]);
    }

    // Visitor Logs for Specific User
    public function visitorLogs(User $user)
    {
        return view('users.visitor-logs', [
            'user'     => $user,
            'visitors' => $user->visitors()->paginate(10),
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
}
