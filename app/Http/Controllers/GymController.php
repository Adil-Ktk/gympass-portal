<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gym;
use App\Models\Area;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| GymController
|--------------------------------------------------------------------------
| This controller handles full CRUD for Gyms.
| Admin can: Add, View, Edit, Delete gyms.
| Each gym belongs to an area and has a gym owner.
*/

class GymController extends Controller
{
    // Show all gyms
    public function index()
    {
        // Get all gyms with their area and owner details
        $gyms = Gym::with(['area', 'owner'])->get();
        return view('admin.gyms.index', compact('gyms'));
    }

    // Show form to create new gym
    public function create()
    {
        // Get all areas for dropdown
        $areas = Area::all();

        // Get all gym owners for dropdown
        $gymOwners = User::where('role', 'gym_owner')->get();

        return view('admin.gyms.create', compact('areas', 'gymOwners'));
    }

    // Save new gym to database
    public function store(Request $request)
    {
        $request->validate([
            'owner_id' => 'required|exists:users,id',
            'area_id'  => 'required|exists:areas,id',
            'gym_name' => 'required|string|max:255',
            'address'  => 'required|string',
        ]);

        Gym::create([
            'owner_id' => $request->owner_id,
            'area_id'  => $request->area_id,
            'gym_name' => $request->gym_name,
            'address'  => $request->address,
        ]);

        return redirect()->route('admin.gyms.index')
                         ->with('success', 'Gym added successfully!');
    }

    // Show form to edit a gym
    public function edit(string $id)
    {
        $gym       = Gym::findOrFail($id);
        $areas     = Area::all();
        $gymOwners = User::where('role', 'gym_owner')->get();

        return view('admin.gyms.edit', compact('gym', 'areas', 'gymOwners'));
    }

    // Save updated gym to database
    public function update(Request $request, string $id)
    {
        $request->validate([
            'owner_id' => 'required|exists:users,id',
            'area_id'  => 'required|exists:areas,id',
            'gym_name' => 'required|string|max:255',
            'address'  => 'required|string',
        ]);

        $gym = Gym::findOrFail($id);
        $gym->update([
            'owner_id' => $request->owner_id,
            'area_id'  => $request->area_id,
            'gym_name' => $request->gym_name,
            'address'  => $request->address,
        ]);

        return redirect()->route('admin.gyms.index')
                         ->with('success', 'Gym updated successfully!');
    }

    // Delete a gym
    public function destroy(string $id)
    {
        $gym = Gym::findOrFail($id);
        $gym->delete();

        return redirect()->route('admin.gyms.index')
                         ->with('success', 'Gym deleted successfully!');
    }
}