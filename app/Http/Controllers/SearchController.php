<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke()
    {
        $query = request('q');

        // Start with base query
        $visitorsQuery = Visitor::where('last_name', 'LIKE', '%' . $query . '%');

        // Add role-based filtering
        if (!auth()->user()->can('view-all-visitors')) {
            // For students/non-admins, only show their own visitors
            $visitorsQuery->where('user_id', auth()->id());
        }

        $visitors = $visitorsQuery->get();

        return view('results', ['visitors' => $visitors]);
    }
}
