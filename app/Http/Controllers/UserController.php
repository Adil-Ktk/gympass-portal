<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| UserController
|--------------------------------------------------------------------------
| This controller handles user management for Admin.
| Admin can: Add, View, Edit, Delete users and gym owners.
*/

class UserController extends Controller
{
    public function index()
    {
        // Get only regular users (members)
        $users = User::where('role', 'user')->get();
        return view('admin.users.index', compact('users'));
    }

    // Show form to create new user
    public function create()
    {
        return view('admin.users.create');
    }

    // Save new user to database
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required|in:user,gym_owner',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User added successfully!');
    }

    // Show form to edit a user
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Save updated user to database
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required|in:user,gym_owner',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User updated successfully!');
    }

    // Delete a user
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User deleted successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | gymOwners() - Show only gym owners
    |--------------------------------------------------------------------------
    | Admin can see only gym owners separately.
    */
    public function gymOwners()
    {
        // Get only users with gym_owner role
        $gymOwners = User::where('role', 'gym_owner')->get();

        return view('admin.gymowners.index', compact('gymOwners'));
    }
}