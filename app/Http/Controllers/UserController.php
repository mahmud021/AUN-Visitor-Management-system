<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        // Get visitors for this user
        $visitors = $user->visitors()->paginate(10);

        // Pass both the user and the visitors to the view
        return view('users.visitor-logs', [
            'user'     => $user,      // single user model
            'visitors' => $visitors,  // collection of visitors
        ]);
    }
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Your create logic (if needed)
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:' . implode(',', array_keys(UserDetails::getRoles())),
            'status' => 'required|in:' . implode(',', array_keys(UserDetails::getStatuses())),
            'school_id' => 'required|string',
            'telephone' => ['required', 'string', 'regex:/^0\d{10}$/', 'min:11', 'max:11'],

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
            'user_id' => $user->id,
        ]);

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     * (Here, we’re using the show() method to display the edit form.)
     */
    public function show(User $user)
    {
        $user->load('user_details');
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validate the input data
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:' . implode(',', array_keys(UserDetails::getRoles())),
            'status' => 'required|in:' . implode(',', array_keys(UserDetails::getStatuses())),
            'school_id' => 'required|string',
            'telephone' => ['required', 'string', 'regex:/^0\d{10}$/', 'min:11', 'max:11'],

        ]);

        // Update the user's basic information
        $user->update([
            'first_name' => ucfirst(strtolower($validated['first_name'])),
            'last_name' => ucfirst(strtolower($validated['last_name'])),
            'email' => $validated['email'],
        ]);

        // Update the user's related details
        $user->user_details->update([
            'role' => $validated['role'],
            'status' => $validated['status'],
            'school_id' => $validated['school_id'],
            'telephone' => $validated['telephone'],
        ]);

        return redirect()->route('user.show', $user->id)
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
