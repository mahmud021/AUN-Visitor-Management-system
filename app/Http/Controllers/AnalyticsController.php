<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $startOfWeek = Carbon::now()->startOfWeek(); // Monday
        $endOfWeek = Carbon::now()->endOfWeek();     // Sunday

        // For MySQL/MariaDB:
        // $dailyVisitors = Visitor::selectRaw("DATE(visit_date) as day, COUNT(*) as total")

        // For SQLite:
        $dailyVisitors = Visitor::selectRaw("strftime('%Y-%m-%d', visit_date) as day, COUNT(*) as total")
            ->whereBetween('visit_date', [$startOfWeek, $endOfWeek])
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->toArray();

        // Build an array keyed by 'YYYY-MM-DD'
        $visitorsByDate = [];
        foreach ($dailyVisitors as $record) {
            $visitorsByDate[$record['day']] = $record['total'];
        }

        // Prepare arrays for the 7 days in the week
        $labels = [];     // e.g. ['Monday', 'Tuesday', ...]
        $chartData = [];  // numeric counts
        $datesOfWeek = []; // store the actual 'YYYY-MM-DD'

        for ($i = 0; $i < 7; $i++) {
            $currentDate = $startOfWeek->copy()->addDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($currentDate)->format('l'); // e.g. "Monday"
            $datesOfWeek[] = $currentDate;                        // "2025-03-19"
            $chartData[] = $visitorsByDate[$currentDate] ?? 0;
        }

        return view('analytics.index', compact('chartData', 'labels', 'datesOfWeek'));
    }
}
