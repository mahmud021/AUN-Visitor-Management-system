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
        // Validate incoming request data
        $validated = $request->validate([
            'first_name'   => 'required|string|max:20',
            'last_name'    => 'required|string|max:20',
            'telephone'    => 'required|string|regex:/^0\d{10}$/|min:11|max:11',
            'visit_date'   => 'required|date|after_or_equal:today',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
        ]);

        // Combine visit_date and end_time to ensure proper datetime handling
        $validated['end_time'] = Carbon::parse($validated['visit_date'] . ' ' . $validated['end_time']);

        // Associate the visitor with the logged-in user and set initial status to pending
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        // Generate a random 4-digit visitor code
        $validated['visitor_code'] = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        // Create the visitor record
        $visitor = Visitor::create($validated);

        // Log timeline event for visitor creation
        TimelineEvent::create([
            'visitor_id'  => $visitor->id,
            'user_id'     => auth()->id(),
            'event_type'  => 'created',
            'description' => 'Visitor record created',
            'occurred_at' => now(),
        ]);

        // Check if the user's details have bypass_hr_approval enabled
        if (auth()->user()->user_details->bypass_hr_approval) {
            $visitor->update(['status' => 'approved']);
            TimelineEvent::create([
                'visitor_id'  => $visitor->id,
                'user_id'     => auth()->id(),
                'event_type'  => 'approved',
                'description' => 'Visitor auto-approved',
                'occurred_at' => now(),
            ]);
        }

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
        $request->validate([
            'status' => 'required|in:approved,denied,checked_in,checked_out',
        ]);

        // Check if the visitor is trying to check in
        if ($request->input('status') === 'checked_in') {
            // Validate the visitor code
            $request->validate([
                'visitor_code'   => 'required|array',
                'visitor_code.*' => 'required|string|size:1',
            ]);

            $inputVisitorCode = implode('', $request->input('visitor_code'));
            if ($visitor->visitor_code !== $inputVisitorCode) {
                return redirect()->back()->withErrors([
                    'visitor_code' => 'The visitor code entered does not match our records.'
                ]);
            }

            // Ensure the visitor is checking in on the correct date
            if (!Carbon::parse($visitor->visit_date)->isToday()) {
                return redirect()->back()->withErrors([
                    'checkin' => 'Visitors can only check in on their scheduled date.'
                ]);
            }

            $visitor->checked_in_at = now();
        }

        // Handle check-out
        if ($request->input('status') === 'checked_out') {
            $visitor->checked_out_at = now();
        }

        // Update the visitor status
        $visitor->status = $request->input('status');
        $visitor->save();

        // Log the timeline event
        $description = match ($visitor->status) {
            'approved'   => 'Visitor approved by HR',
            'denied'     => 'Visitor denied',
            'checked_in' => 'Visitor checked in by security',
            'checked_out'=> 'Visitor checked out by security',
            default      => '',
        };

        TimelineEvent::create([
            'visitor_id'  => $visitor->id,
            'user_id'     => auth()->id(),
            'event_type'  => $visitor->status,
            'description' => $description,
            'occurred_at' => now(),
        ]);

        return redirect()->back();
    }    public function destroy(Visitor $visitor)
    {
        // Delete the visitor if needed.
    }
}
