<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

/*
|--------------------------------------------------------------------------
| AreaController
|--------------------------------------------------------------------------
| This controller handles full CRUD for Areas.
| Admin can: Add, View, Edit, Delete areas.
| Areas are cities like Islamabad, Rawalpindi, DHA, Bahria.
*/

class AreaController extends Controller
{
    /*
    | index() - Show all areas
    | URL: /admin/areas
    */
    public function index()
    {
        // Get all areas from database
        $areas = Area::all();
        return view('admin.areas.index', compact('areas'));
    }

    /*
    | create() - Show form to add new area
    | URL: /admin/areas/create
    */
    public function create()
    {
        return view('admin.areas.create');
    }

    /*
    | store() - Save new area to database
    | URL: POST /admin/areas
    */
    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'name' => 'required|string|max:255|unique:areas',
        ]);

        // Create the area in database
        Area::create(['name' => $request->name]);

        // Redirect back with success message
        return redirect()->route('admin.areas.index')
                         ->with('success', 'Area added successfully!');
    }

    /*
    | edit() - Show form to edit an area
    | URL: /admin/areas/{id}/edit
    */
    public function edit(String $id)
    {
        // Find the area by id
        $area = Area::findOrFail($id);
        return view('admin.areas.edit', compact('area'));
    }

    /*
    | update() - Save updated area to database
    | URL: PUT /admin/areas/{id}
    */
    public function update(Request $request, String $id)
    {
        // Validate form data
        $request->validate([
            'name' => 'required|string|max:255|unique:areas,name,' . $id,
        ]);

        // Find and update the area
        $area = Area::findOrFail($id);
        $area->update(['name' => $request->name]);

        return redirect()->route('admin.areas.index')
                         ->with('success', 'Area updated successfully!');
    }

    /*
    | destroy() - Delete an area from database
    | URL: DELETE /admin/areas/{id}
    */
    public function destroy(String $id)
    {
        // Find and delete the area
        $area = Area::findOrFail($id);
        $area->delete();

        return redirect()->route('admin.areas.index')
                         ->with('success', 'Area deleted successfully!');
    }
}