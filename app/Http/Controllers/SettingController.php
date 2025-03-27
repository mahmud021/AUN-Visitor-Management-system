<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\Location;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AppSetting $appSetting)
    {
        //
    }
    public function storeLocation(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:locations,name',
        ]);

        Location::create($data);

        return redirect()->route('settings.edit')->with('status', 'Location added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $settings = AppSetting::first();  // There's only one row (assuming)
        $locations = \App\Models\Location::all();

        return view('settings.edit', compact('settings', 'locations'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'visitor_start_time' => 'required',
            'visitor_end_time'   => 'required',
        ]);

        $settings = AppSetting::first();
        $settings->update($data);

        return redirect()->route('settings.edit')->with('status', 'Settings updated!');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroyLocation(Location $location)
    {
        // Delete the location record
        $location->delete();

        // Redirect back to the settings edit page with a success message
        return redirect()->route('settings.edit')->with('status', 'Location deleted successfully.');
    }
    public function destroy(AppSetting $appSetting)
    {
        //
    }
}
