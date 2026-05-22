<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

/*
|--------------------------------------------------------------------------
| PlanController
|--------------------------------------------------------------------------
| This controller handles full CRUD for Plans.
| Admin can: Add, View, Edit, Delete membership plans.
| Example plans: Monthly Plan (30 days, Rs.2000)
*/

class PlanController extends Controller
{
    // Show all plans
    public function index()
    {
        $plans = Plan::all();
        return view('admin.plans.index', compact('plans'));
    }

    // Show form to create new plan
    public function create()
    {
        return view('admin.plans.create');
    }

    // Save new plan to database
    public function store(Request $request)
    {
        $request->validate([
            'plan_name'     => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price'         => 'required|numeric|min:0',
        ]);

        Plan::create([
            'plan_name'     => $request->plan_name,
            'duration_days' => $request->duration_days,
            'price'         => $request->price,
        ]);

        return redirect()->route('admin.plans.index')
                         ->with('success', 'Plan added successfully!');
    }

    // Show form to edit a plan
    public function edit(String $id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin.plans.edit', compact('plan'));
    }

    // Save updated plan to database
    public function update(Request $request, String $id)
    {
        $request->validate([
            'plan_name'     => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price'         => 'required|numeric|min:0',
        ]);

        $plan = Plan::findOrFail($id);
        $plan->update([
            'plan_name'     => $request->plan_name,
            'duration_days' => $request->duration_days,
            'price'         => $request->price,
        ]);

        return redirect()->route('admin.plans.index')
                         ->with('success', 'Plan updated successfully!');
    }

    // Delete a plan
    public function destroy(String $id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();

        return redirect()->route('admin.plans.index')
                         ->with('success', 'Plan deleted successfully!');
    }
}