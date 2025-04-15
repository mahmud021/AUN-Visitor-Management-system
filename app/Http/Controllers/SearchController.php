<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function dashboardSearch(Request $request)
    {
        $query = $request->input('q'); // Using $request to get the search query

        // Start with base query
        $visitorsQuery = Visitor::where('first_name', 'LIKE', '%' . $query . '%')
            ->orWhere('last_name', 'LIKE', '%' . $query . '%'); // Search both first and last name

        // Add role-based filtering
        if (!auth()->user()->can('view-all-visitors')) {
            // For students/non-admins, only show their own visitors
            $visitorsQuery->where('user_id', auth()->id());
        }

        $visitors = $visitorsQuery->get();

        return view('results', ['visitors' => $visitors]);
    }
}
