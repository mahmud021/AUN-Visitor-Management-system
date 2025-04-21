<?php

namespace App\Http\Controllers;

use App\Mail\VisitorQRCodeMail;
use App\Models\Location;
use App\Models\TimelineEvent;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::orderBy('created_at', 'desc')->simplePaginate(10);
        return view('visitors.index', compact('visitors'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q'); // Get the search query

        // Start building the query to search by first name and last name
        $visitorsQuery = Visitor::query();

        if ($query) {
            $visitorsQuery->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('first_name', 'LIKE', '%' . $query . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $query . '%');
            });
        }

        // Get the filtered visitors
        $visitors = $visitorsQuery->paginate(10); // Paginate the search results

        return view('visitors.index', compact('visitors'));
    }
    public function create()
    {

    }

    public function store(Request $request)
    {
        // Retrieve the allowed time window from settings
        $settings = \App\Models\AppSetting::first();
        $start = \Carbon\Carbon::parse($settings->visitor_start_time);
        $end   = \Carbon\Carbon::parse($settings->visitor_end_time);
        $now   = \Carbon\Carbon::now();

        // Check if current time is within the allowed window
        if (!$now->between($start, $end)) {
            if (!\Illuminate\Support\Facades\Gate::allows('override-visitor-creation')) {
                return redirect()->back()->withErrors([
                    'time_window' => 'Visitor creation is not allowed outside the designated time window.'
                ]);
            }
        }

        // Validate incoming request data
        $validated = $request->validate([
            'first_name'         => 'required|string|max:20',
            'last_name'          => 'required|string|max:20',
            'telephone'          => 'required|string|regex:/^0\d{10}$/|min:11|max:11',
            'visit_date'         => 'required|date|after_or_equal:today',
            'start_time'         => 'required|date_format:H:i',
            'end_time'           => 'required|date_format:H:i|after:start_time',
            'location'           => 'required|string|max:50',
            'purpose_of_visit'   => 'required|string|max:100',
        ]);

        // Convert end_time to proper datetime if needed
        $validated['end_time'] = \Carbon\Carbon::parse($validated['visit_date'] . ' ' . $validated['end_time']);

        // Assign user_id and status based on visitor type
        if ($request->has('walk_in')) {
            $validated['user_id'] = null;
            $validated['status'] = 'checked_in';
            $validated['checked_in_at'] = now();
        } else {
            $validated['user_id'] = auth()->id();
            $validated['status'] = 'pending';
        }

        // Generate visitor code and token
        $validated['visitor_code'] = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $validated['token'] = Str::uuid()->toString();

        // Create the visitor
        $visitor = Visitor::create($validated);

        // Timeline event: created
        \App\Models\TimelineEvent::create([
            'visitor_id'  => $visitor->id,
            'user_id'     => auth()->id(),
            'event_type'  => 'created',
            'description' => 'Visitor record created',
            'occurred_at' => now(),
        ]);

        // Walk-in gets auto checked-in — log that too
        if ($request->has('walk_in')) {
            \App\Models\TimelineEvent::create([
                'visitor_id'  => $visitor->id,
                'user_id'     => null,
                'event_type'  => 'checked_in',
                'description' => 'Walk-in visitor checked in automatically.',
                'occurred_at' => now(),
            ]);
        }

        // Auto-approve if user has bypass_hr_approval
        if (!$request->has('walk_in') && auth()->user()->user_details->bypass_hr_approval) {
            $visitor->update(['status' => 'approved']);

            \App\Models\TimelineEvent::create([
                'visitor_id'  => $visitor->id,
                'user_id'     => auth()->id(),
                'event_type'  => 'approved',
                'description' => 'Visitor auto-approved',
                'occurred_at' => now(),
            ]);
        }

        // Generate QR code
        $qrCode = QrCode::format('png')->size(400)->generate($visitor->token);
        return redirect()->back()
            ->with('success', 'Visitor created successfully.');
    }
    public function show(Visitor $visitor)
    {
        $qrCode = session('qrCode');

        // If the QR code is missing, regenerate it
        if (!$qrCode) {
            $qrCode = QrCode::format('png')->size(400)->generate($visitor->token);        }

        return view('visitors.show', compact('visitor', 'qrCode'));
    }

    public function edit(Visitor $visitor)
    {
        $locations = Location::all(); // or however you fetch locations
        return view('visitors.edit', compact('visitor', 'locations'));
    }




    /**
     * Update visitor personal details.
     *
     * This update method is dedicated to updating the visitor’s basic information:
     * first name, last name, telephone, visit date, start time, and end time.
     */

    public function checkIn(Request $request, Visitor $visitor)
    {
        // Validate the visitor code.
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

        // Ensure the visitor is checking in on the correct date.
        if (!\Carbon\Carbon::parse($visitor->visit_date)->isToday()) {
            return redirect()->back()->withErrors([
                'checkin' => 'Visitors can only check in on their scheduled date.'
            ]);
        }

        // Update the visitor record with check‑in details.
        $visitor->checked_in_at = now();
        $visitor->status = 'checked_in';
        $visitor->save();

        // Log the timeline event.
        \App\Models\TimelineEvent::create([
            'visitor_id'  => $visitor->id,
            'user_id'     => auth()->id(),
            'event_type'  => 'checked_in',
            'description' => 'Visitor checked in by security',
            'occurred_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Visitor checked in successfully.');
    }

    public function autoCheckIn(Visitor $visitor)
    {
        // Prevent duplicate check‑ins
        if ($visitor->status === 'checked_in') {
            return redirect()->back()->withErrors([
                'checkin' => 'Visitor is already checked in.',
            ]);
        }

        // Only allow checking in on the scheduled date
        if (! \Carbon\Carbon::parse($visitor->visit_date)->isToday()) {
            return redirect()->back()->withErrors([
                'checkin' => 'Visitors can only check in on their scheduled date.',
            ]);
        }

        // Perform the check‑in
        $visitor->update([
            'status'        => 'checked_in',
            'checked_in_at' => now(),
        ]);

        // Log the event
        TimelineEvent::create([
            'visitor_id'  => $visitor->id,
            'user_id'     => auth()->id(),
            'event_type'  => 'checked_in',
            'description' => 'Visitor automatically checked in via QR scan',
            'occurred_at' => now(),
        ]);

        return redirect()
            ->route('visitors.scan')     // or wherever you want to send them
            ->with('success', 'Visitor checked in successfully.');
    }


    public function update(Request $request, Visitor $visitor)
    {
        if ($request->has('status') && $request->input('status') === 'checked_in') {
            if (auth()->user()->user_details->role === 'Security') {
                abort(403, 'Security users must use the check‑in route.');
            }
        }

        if ($request->has('status')) {
            $request->validate([
                'status' => 'required|in:approved,denied,checked_out',
            ]);

            if ($request->input('status') === 'checked_out') {
                $visitor->checked_out_at = now();
            }

            $visitor->status = $request->input('status');
            $visitor->save();

            $description = match ($visitor->status) {
                'approved'    => 'Visitor approved by HR',
                'denied'      => 'Visitor denied',
                'checked_out' => 'Visitor checked out by security',
                default       => '',
            };

            \App\Models\TimelineEvent::create([
                'visitor_id'  => $visitor->id,
                'user_id'     => auth()->id(),
                'event_type'  => $visitor->status,
                'description' => $description,
                'occurred_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Visitor status updated successfully.');
        }

        \Illuminate\Support\Facades\Gate::authorize('update-visitor', $visitor);

        $validated = $request->validate([
            'first_name'         => 'required|string|max:20',
            'last_name'          => 'required|string|max:20',
            'telephone'          => 'required|string|regex:/^0\d{10}$/|min:11|max:11',
            'visit_date'         => 'required|date',
            'start_time'         => 'required|date_format:H:i',
            'end_time'           => 'required|date_format:H:i|after:start_time',
            'location'           => 'required|string|max:50',
            'purpose_of_visit'   => 'required|string|max:100',
        ]);

        $visitor->first_name        = $validated['first_name'];
        $visitor->last_name         = $validated['last_name'];
        $visitor->telephone         = $validated['telephone'];
        $visitor->visit_date        = $validated['visit_date'];
        $visitor->start_time        = $validated['start_time'];
        $visitor->end_time          = $validated['end_time'];
        $visitor->location          = $validated['location'];
        $visitor->purpose_of_visit  = $validated['purpose_of_visit'];
        $visitor->save();

        \App\Models\TimelineEvent::create([
            'visitor_id'  => $visitor->id,
            'user_id'     => auth()->id(),
            'event_type'  => 'updated_details',
            'description' => 'Visitor personal details updated',
            'occurred_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Visitor updated successfully.');
    }


    public function timeline(Visitor $visitor)
    {
        $visitor->load('timelineEvents.user');
        return view('visitors.timeline', compact('visitor'));
    }

    public function destroy(Visitor $visitor)
    {
        // Delete the visitor if needed.
    }

    // VisitorController.php
    public function processScan(Request $request)
    {
        $request->validate([
            'qr_content' => 'required|string',
        ]);

        $visitor = Visitor::where('token', $request->qr_content)->first();

        if (! $visitor) {
            return redirect()->route('visitors.scan')
                ->withErrors(['qr_content' => 'No visitor found with this QR code.']);
        }

        if ($visitor->status === 'checked_in') {
            return redirect()->route('visitors.scan')
                ->withErrors(['checkin' => 'Visitor is already checked in.']);
        }

        if (! Carbon::parse($visitor->visit_date)->isToday()) {
            return redirect()->route('visitors.scan')
                ->withErrors(['checkin' => 'Visitors can only check in on their scheduled date.']);
        }

        // Render the same scan view, now with a $visitor to confirm
        return view('visitors.scan', compact('visitor'));
    }


}
