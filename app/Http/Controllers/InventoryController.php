<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventory = Inventory::all();

        return view('inventory.index', compact('inventory'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'appliance_name' => 'required|string|max:255',
            'location'       => 'required|string|max:255',
            'brand'          => 'required|string|max:255',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('appliance_images', 'public');
        }

        // Create inventory record
        $inventory = Inventory::create([
            'user_id'        => Auth::id(),
            'appliance_name' => $validated['appliance_name'],
            'location'       => $validated['location'],
            'brand'          => $validated['brand'],
            'image_path'     => $imagePath,
            'status'         => 'pending',   // optional if you want a default status
            'checked_in_at'  => now(),
        ]);

        // ***** Log timeline event for creating the Inventory item *****
        $inventory->timelineEvents()->create([
            'user_id'     => auth()->id(),
            'event_type'  => 'created',
            'description' => 'Inventory record created',
            'occurred_at' => now(),
        ]);

        // Redirect with success message
        return redirect()->route('inventory.index')
            ->with('success', 'Appliance added successfully!');
    }



    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        return view('inventory.show', compact('inventory'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        // 1. Validate status (optional if you want to allow other updates)
        $request->validate([
            'status' => 'nullable|in:pending,checked_in,checked_out'
        ]);

        // 2. If the request includes a 'status', do check-in/check-out logic
        if ($request->filled('status')) {
            if ($request->input('status') === 'checked_in') {
                $inventory->checked_in_at = now();
                $inventory->checked_out_at = null; // optional
            } elseif ($request->input('status') === 'checked_out') {
                $inventory->checked_out_at = now();
            }

            $inventory->status = $request->input('status');
        }

        // 3. Save any changes (status, location, brand, etc.)
        $inventory->save();

        // 4. Log a timeline event if the user changed the status
        if ($request->filled('status')) {
            $inventory->timelineEvents()->create([
                'user_id'     => auth()->id(),
                'event_type'  => $request->input('status'), // e.g., 'checked_in'
                'description' => "Item status changed to {$request->input('status')}",
                'details'     => "Changed at " . now()->format('Y-m-d H:i'),
                'occurred_at' => now(),
            ]);
        }

        // 5. Redirect with success
        return redirect()->back()->with('success', 'Inventory updated successfully.');
    }


    public function timeline(Inventory $inventory)
    {
        // Eager load the user relationship for each event if desired:
        $inventory->load(['timelineEvents.user']);

        return view('inventory.timeline', compact('inventory'));
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
