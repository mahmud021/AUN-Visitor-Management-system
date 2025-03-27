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
            'location' => 'required|string|max:255', // Location is now selected from a dropdown, so make it required
            'brand' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('appliance_images', 'public');
        }

        // Create inventory record
        Inventory::create([
            'user_id' => Auth::id(),
            'appliance_name' => $validated['appliance_name'],
            'location' => $validated['location'],
            'brand' => $validated['brand'],
            'image_path' => $imagePath,
            'checked_in_at' => now(),
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
        // If the request includes a 'status', we process check-in/out logic.
        if ($request->has('status')) {
            $request->validate([
                'status' => 'required|in:pending,checked_in,checked_out',
            ]);

            // If they are checking in...
            if ($request->input('status') === 'checked_in') {
                $inventory->checked_in_at = now();
                // Optionally reset checked_out_at
                // $inventory->checked_out_at = null;
            }

            // If they are checking out...
            if ($request->input('status') === 'checked_out') {
                $inventory->checked_out_at = now();
            }

            // Update the inventory record’s status
            $inventory->status = $request->input('status');
            $inventory->save();

            // Optionally log a timeline event or do other logic here

            return redirect()->back()->with('success', 'Inventory status updated successfully.');
        }

        // Otherwise handle other form updates, if any
        // For example: name, brand, location, etc.
        // ...

        return redirect()->back()->with('success', 'Inventory updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
