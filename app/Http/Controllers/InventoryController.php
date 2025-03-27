<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Correct order: latest() first, then pagination
        $locations = \App\Models\Location::all();

        $inventory = Inventory::latest()->simplePaginate(10);

        return view('inventory.index', compact('inventory', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

        // Log timeline event for creating the inventory item
        $inventory->timelineEvents()->create([
            'user_id'     => auth()->id(),
            'event_type'  => 'created',
            'description' => 'Inventory record created',
            'occurred_at' => now(),
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Inventory updated successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)

    {
        Gate::authorize('view-inventory-item', $inventory);

        return view('inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)

    {
        $locations = \App\Models\Location::all();
        return view('inventory.edit', compact('inventory', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        Gate::authorize('update-inventory', $inventory);

        // Remove _token and _method from request data
        $inputData = $request->except(['_token', '_method']);

        // Check if the request is only updating the status
        if (count($inputData) === 1 && isset($inputData['status'])) {
            // Validate only the status field
            $validated = $request->validate([
                'status' => 'required|in:pending,checked_in,missing,checked_out',
            ]);

            // Update status and handle timestamps accordingly
            if ($validated['status'] === 'checked_in') {
                $inventory->checked_in_at = now();
                $inventory->checked_out_at = null; // reset check-out time
            } elseif ($validated['status'] === 'checked_out') {
                $inventory->checked_out_at = now();
            }
            $inventory->status = $validated['status'];
        } else {
            // Validate all required fields for a full update
            $validated = $request->validate([
                'appliance_name' => 'required|string|max:255',
                'brand'          => 'required|string|max:255',
                'location'       => 'required|string|max:255',
                'image_path'     => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                // Optionally include status validation if needed
                'status'         => 'nullable|in:pending,checked_in,missing,checked_out',
            ]);

            // Update basic fields
            $inventory->appliance_name = $validated['appliance_name'];
            $inventory->brand          = $validated['brand'];
            $inventory->location       = $validated['location'];

            // Handle image upload if a new image is provided
            if ($request->hasFile('image_path')) {
                $imagePath = $request->file('image_path')->store('appliance_images', 'public');
                $inventory->image_path = $imagePath;
            }

            // Optional: Handle status update if provided
            if ($request->filled('status')) {
                if ($request->input('status') === 'checked_in') {
                    $inventory->checked_in_at = now();
                    $inventory->checked_out_at = null; // reset check-out time
                } elseif ($request->input('status') === 'checked_out') {
                    $inventory->checked_out_at = now();
                }
                $inventory->status = $request->input('status');
            }
        }

        // Save changes to the inventory
        $inventory->save();

        // Log timeline event for updating the inventory
        $inventory->timelineEvents()->create([
            'user_id'     => auth()->id(),
            'event_type'  => 'updated',
            'description' => 'Inventory record updated',
            'occurred_at' => now(),
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Inventory updated successfully.');
    }


    /**
     * Display the timeline for the specified inventory.
     */
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
