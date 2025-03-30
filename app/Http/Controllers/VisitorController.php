<?php

namespace App\Http\Controllers;

use App\Mail\VisitorQRCodeMail;
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

    public function create()
    {
        return view('visitors.create');
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
            'first_name'   => 'required|string|max:20',
            'last_name'    => 'required|string|max:20',
            'telephone'    => 'required|string|regex:/^0\d{10}$/|min:11|max:11',
            'visit_date'   => 'required|date|after_or_equal:today',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
        ]);

        // Combine visit_date and end_time to ensure proper datetime handling
        $validated['end_time'] = \Carbon\Carbon::parse($validated['visit_date'] . ' ' . $validated['end_time']);

        // Associate the visitor with the logged-in user and set initial status to pending
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';
        $validated['visitor_code'] = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        // Generate a unique token for the QR code
        $validated['token'] = Str::uuid()->toString();

        // Create the visitor record
        $visitor = Visitor::create($validated);

        // Log timeline event for visitor creation
        \App\Models\TimelineEvent::create([
            'visitor_id'  => $visitor->id,
            'user_id'     => auth()->id(),
            'event_type'  => 'created',
            'description' => 'Visitor record created',
            'occurred_at' => now(),
        ]);

        // Auto-approve if user has bypass_hr_approval
        if (auth()->user()->user_details->bypass_hr_approval) {
            $visitor->update(['status' => 'approved']);
            \App\Models\TimelineEvent::create([
                'visitor_id'  => $visitor->id,
                'user_id'     => auth()->id(),
                'event_type'  => 'approved',
                'description' => 'Visitor auto-approved',
                'occurred_at' => now(),
            ]);
        }

        // Generate the QR code in PNG format
        $qrCode = QrCode::format('png')->size(200)->generate($visitor->token);

        // Redirect to a view to display the QR code
        return redirect()->route('visitors.show', $visitor->id)->with('qrCode', $qrCode)->with('success', 'Visitor Created successfully.');
    }
    public function show(Visitor $visitor)
    {
        $qrCode = session('qrCode');

        // If the QR code is missing, regenerate it
        if (!$qrCode) {
            $qrCode = QrCode::format('png')->size(200)->generate($visitor->token);
        }

        return view('visitors.qr', compact('visitor', 'qrCode'));
    }

    public function edit(Visitor $visitor)
    {
        return view('visitors.edit', compact('visitor'));
    }



    /**
     * Update visitor personal details.
     *
     * This update method is dedicated to updating the visitor’s basic information:
     * first name, last name, telephone, visit date, start time, and end time.
     */
    public function update(Request $request, Visitor $visitor)
    {
        // If the request includes a 'status', process check‑in/out logic.
        if ($request->has('status')) {
            $request->validate([
                'status' => 'required|in:approved,denied,checked_in,checked_out',
            ]);

            // Check if the visitor is trying to check in.
            if ($request->input('status') === 'checked_in') {
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
                if (!Carbon::parse($visitor->visit_date)->isToday()) {
                    return redirect()->back()->withErrors([
                        'checkin' => 'Visitors can only check in on their scheduled date.'
                    ]);
                }

                $visitor->checked_in_at = now();
            }

            // Handle check-out.
            if ($request->input('status') === 'checked_out') {
                $visitor->checked_out_at = now();
            }

            // Update the visitor status.
            $visitor->status = $request->input('status');
            $visitor->save();

            // Log the timeline event.
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

            return redirect()->back()->with('success', 'Visitor status updated successfully.');
        }

        // Use the new 'edit-visitor' gate to check if the user can update personal details.
        Gate::authorize('update-visitor', $visitor);

        // Validate personal details.
        $validated = $request->validate([
            'first_name' => 'required|string|max:20',
            'last_name'  => 'required|string|max:20',
            'telephone'  => 'required|string|regex:/^0\d{10}$/|min:11|max:11',
            'visit_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
        ]);

        // Explicitly assign each field.
        $visitor->first_name = $validated['first_name'];
        $visitor->last_name  = $validated['last_name'];
        $visitor->telephone  = $validated['telephone'];
        $visitor->visit_date = $validated['visit_date'];
        $visitor->start_time = $validated['start_time'];
        $visitor->end_time   = $validated['end_time'];
        $visitor->save();

        // Log a timeline event for updating personal details.
        TimelineEvent::create([
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
}
