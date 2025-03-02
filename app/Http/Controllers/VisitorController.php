<?php

namespace App\Http\Controllers;

use App\Models\TimelineEvent;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::orderBy('created_at', 'desc')->simplePaginate(10);
        return view('visitors.index', compact('visitors'));
    }

    public function create() {
        return view('visitors.create');
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'telephone' => 'required|string|regex:/^0\d{10}$/|min:11|max:11',
            'expected_arrival' => 'required|date_format:Y-m-d\TH:i',
            'visit_end' => 'required|date_format:Y-m-d\TH:i|after:expected_arrival',
        ]);

        // Convert datetime-local format to proper datetime
        $validated['expected_arrival'] = Carbon::createFromFormat(
            'Y-m-d\TH:i',
            $validated['expected_arrival']
        );

        $validated['visit_end'] = Carbon::createFromFormat(
            'Y-m-d\TH:i',
            $validated['visit_end']
        );

        $validated['user_id'] = auth()->id();
        $validated['visitor_code'] = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        $visitor = Visitor::create($validated);

        TimelineEvent::create([
            'visitor_id' => $visitor->id,
            'user_id' => auth()->id(),
            'event_type' => 'window_set',
            'description' => sprintf(
                'Visit window: %s to %s',
                $visitor->expected_arrival->format('M j, Y g:i a'),
                $visitor->visit_end->format('M j, Y g:i a')
            ),
            'occurred_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Visitor created successfully.');
    }

    public function show(Visitor $visitor)
    {
        // Show a single visitor
    }

    public function edit(Visitor $visitor)
    {
        // Edit visitor form
    }

    public function timeline(Visitor $visitor)
    {
        $visitor->load('timelineEvents.user');
        return view('visitors.timeline', compact('visitor'));
    }

    public function update(Request $request, Visitor $visitor)
    {
        // Validate the basic status update input.
        $request->validate([
            'status' => 'required|in:approved,denied,checked_in,checked_out',
        ]);



        // Update the visitor status.
        $visitor->status = $request->input('status');
        $visitor->save();

        $description = '';
        switch ($visitor->status) {
            case 'approved':
                $description = 'Visitor approved by HR';
                break;
            case 'denied':
                $description = 'Visitor denied';
                break;
            case 'checked_in':
                $description = 'Visitor checked in by security';
                break;
            case 'checked_out':
                $description = 'Visitor checked out by security';
                break;
        }

        // Log the timeline event for the status update.
        TimelineEvent::create([
            'visitor_id'  => $visitor->id,
            'user_id'     => auth()->id(),
            'event_type'  => $visitor->status,
            'description' => $description,
            'occurred_at' => now(),
        ]);

        return redirect()->back();
    }

    public function destroy(Visitor $visitor)
    {
        // Delete the visitor if needed.
    }
}
