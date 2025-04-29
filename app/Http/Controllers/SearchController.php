<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function dashboardSearch(Request $request)
    {
        $query = $request->input('q');

        $results = [
            'myVisitors' => Visitor::where('user_id', auth()->id())
                ->where(function($q) use ($query) {
                    $q->where('first_name', 'LIKE', "%$query%")
                        ->orWhere('last_name', 'LIKE', "%$query%");
                })->get(),
            'allVisitors' => collect() // Initialize empty collection
        ];

        if (auth()->user()->can('view-all-visitors')) {
            $results['allVisitors'] = Visitor::where('first_name', 'LIKE', "%$query%")
                ->orWhere('last_name', 'LIKE', "%$query%")
                ->get();
        }

        return view('dashboard.results', $results);
    }
}
