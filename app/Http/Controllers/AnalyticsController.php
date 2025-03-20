<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Define the start and end of the week
        $startOfWeek = Carbon::now()->startOfWeek(); // Monday
        $endOfWeek = Carbon::now()->endOfWeek();       // Sunday

        // Use SQLite's strftime to extract the day number (0 for Sunday, 1 for Monday, etc.)
        $dailyVisitors = Visitor::selectRaw("strftime('%w', visit_date) as day, COUNT(*) as total")
            ->whereBetween('visit_date', [$startOfWeek, $endOfWeek])
            ->groupBy('day')
            ->get();

        // Mapping from SQLite day number to day name
        $dayNameMapping = [
            '0' => 'Sunday',
            '1' => 'Monday',
            '2' => 'Tuesday',
            '3' => 'Wednesday',
            '4' => 'Thursday',
            '5' => 'Friday',
            '6' => 'Saturday'
        ];

        // Initialize an array for Monday to Sunday with 0 counts
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $visitorsData = array_fill_keys($daysOfWeek, 0);

        // Populate the data array with actual counts
        foreach ($dailyVisitors as $record) {
            $dayName = $dayNameMapping[$record->day];
            $visitorsData[$dayName] = $record->total;
        }

        return view('analytics.index', compact('visitorsData'));
    }
}
