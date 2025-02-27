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
        // Validate incoming request data.
        $validated = $request->validate([
            'first_name'       => 'required|string|max:20',
            'last_name'        => 'required|string|max:20',
            'telephone'        => 'required|string|regex:/^0\d{10}$/|min:11|max:11',
            'expected_arrival' => 'required|date|after_or_equal:today',
        ]);

        // Associate the visitor with the logged-in user.
        $validated['user_id'] = auth()->id();

        // Generate a random 4-digit visitor code (as a string, padded with leading zeros if needed).
        $validated['visitor_code'] = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        // Create the visitor.
        $visitor = Visitor::create($validated);

        // Log the timeline event for visitor creation.
        TimelineEvent::create([
            'visitor_id'  => $visitor->id,
            'user_id'     => auth()->id(),
            'event_type'  => 'created',
            'description' => 'Visitor record created',
            'occurred_at' => now(),
        ]);

        return redirect()->back();
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

        // If updating status to "checked_in", ensure the visitor code is provided and correct.
        if ($request->input('status') === 'checked_in') {
            $request->validate([
                'visitor_code' => 'required',
            ]);

            if ($visitor->visitor_code !== $request->visitor_code) {
                return redirect()->back()->withErrors(['visitor_code' => 'The visitor code entered does not match our records.']);
            }
        }

        // Update the status column.
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
