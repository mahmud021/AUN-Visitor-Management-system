<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('user_details')->latest()->simplePaginate(10);
        return view('users.index', compact('users'));
    }

    public function visitorLogs(User $user)
    {

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }
    public function edit(User $user)
    {
        $user->load('user_details');
        return view('users.edit', compact('user'))->with('success', 'User details updated successfully.');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Capitalize first letter of first_name and last_name
        $request->merge([
            'first_name' => ucfirst(strtolower($request->first_name)),
            'last_name' => ucfirst(strtolower($request->last_name)),
        ]);

        // Validate the request
        $validated = $request->validate([
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8',
            'role' => ['required', Rule::in(array_keys(UserDetails::getRoles()))],
            'status' => ['required', Rule::in(array_keys(UserDetails::getStatuses()))],
            'school_id' => 'required|string|unique:user_details,school_id',
            'telephone' => ['required', 'string', 'regex:/^0\d{10}$/', 'min:11', 'max:11'],
            'blacklist' => 'boolean',
            // Here's our new field. "sometimes|boolean" means if it's not in the request, it won't fail.
            'bypass_late_checkin' => 'sometimes|boolean',
        ], [
            'school_id.unique' => 'This School ID is already assigned to another user.',
        ]);

        // Create the user
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'remember_token' => Str::random(60),
        ]);

        // Create the user details record
        UserDetails::create([
            'role' => $validated['role'],
            'status' => $validated['status'],
            'school_id' => $validated['school_id'],
            'telephone' => $validated['telephone'],
            'blacklist' => $validated['blacklist'] ?? false,
            'bypass_hr_approval' => true, // or override if needed
            // Our new field: default to false if not given
            'bypass_late_checkin' => $validated['bypass_late_checkin'] ?? false,
            'user_id' => $user->id,
        ]);

        return redirect()->route('user.index')
            ->with('success', 'User created successfully.');
    }


    /**
     * Display the specified resource.
     * (Here, we’re using the show() method to display the edit form.)
     */
    public function show(User $user)
    {
        // Check if the current user is allowed to view this profile.
        if (Gate::denies('view-profile', $user)) {
            abort(403);
        }

        $visitors = $user->visitors()->simplePaginate(10);
        $inventoryItems = $user->inventory()->simplePaginate(10);

        return view('users.show', compact('user', 'visitors', 'inventoryItems'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validate the incoming data including the new bypass_late_checkin field
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:' . implode(',', array_keys(UserDetails::getRoles())),
            'status' => 'required|in:' . implode(',', array_keys(UserDetails::getStatuses())),
            'school_id' => 'required|string',
            'blacklist' => 'boolean',
            'telephone' => ['required', 'string', 'regex:/^0\d{10}$/', 'min:11', 'max:11'],
            'bypass_hr_approval' => 'sometimes|boolean',
            'bypass_late_checkin' => 'sometimes|boolean',
        ]);

        // Update the user's basic information
        $user->update([
            'first_name' => ucfirst(strtolower($validated['first_name'])),
            'last_name' => ucfirst(strtolower($validated['last_name'])),
            'email' => $validated['email'],
        ]);

        // Update the user's related details, including the new bypass_late_checkin
        $user->user_details->update([
            'role' => $validated['role'],
            'status' => $validated['status'],
            'blacklist' => $validated['blacklist'],
            'school_id' => $validated['school_id'],
            'telephone' => $validated['telephone'],
            'bypass_hr_approval' => $validated['bypass_hr_approval']
                ?? $user->user_details->bypass_hr_approval,
            'bypass_late_checkin' => $validated['bypass_late_checkin']
                ?? $user->user_details->bypass_late_checkin,
        ]);

        return redirect()->route('user.edit', $user->id)
            ->with('success', 'User updated successfully.');
    }


    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request, User $user)
    {
        // Validate the new password (the 'confirmed' rule checks for a matching 'password_confirmation' field)
        $validated = $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        // Update the user's password
        $user->update([
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('user.show', $user->id)
            ->with('password_success', 'User password updated successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('q'); // Get search query from request

        // Search query logic as before
        $usersQuery = User::query();

        if ($query) {
            $usersQuery->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('first_name', 'LIKE', '%' . $query . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $query . '%')
                    ->orWhere('email', 'LIKE', '%' . $query . '%');
            });
        }

        $users = $usersQuery->simplePaginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        // Validate that a password is provided for deletion confirmation
        $request->validate([
            'password' => 'required',
        ]);

        // Check that the provided password matches the user's password
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['userDeletion' => 'Password does not match.']);
        }

        // Delete the user
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
}
