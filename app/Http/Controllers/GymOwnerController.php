<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Membership;
use App\Models\VisitLog;
use App\Models\Gym;

/*
|--------------------------------------------------------------------------
| GymOwnerController
|--------------------------------------------------------------------------
| This controller handles the Gym Owner module.
| Gym owner can: Verify membership codes, log visits, view visit history.
*/

class GymOwnerController extends Controller
{
    /*
    | dashboard() - Show gym owner dashboard
    */
    public function dashboard()
    {
        // Get the gym owned by this gym owner
        $gym = Gym::where('owner_id', Auth::id())->first();

        // Get total visits for this gym
        $totalVisits = 0;
        if ($gym) {
            $totalVisits = VisitLog::where('gym_id', $gym->id)->count();
        }

        return view('gymowner.dashboard', compact('gym', 'totalVisits'));
    }

    /*
    | verifyForm() - Show the membership verification form
    */
    public function verifyForm()
    {
        return view('gymowner.verify');
    }

    /*
    | verify() - Process membership code verification
    | This is the core logic of the gym owner module
    */
    public function verify(Request $request)
    {
        $request->validate([
            'membership_code' => 'required|string',
        ]);

        // Step 1: Get the gym of this owner
        $gym = Gym::where('owner_id', Auth::id())->first();

        if (!$gym) {
            return back()->with('error', 'No gym found for your account!');
        }

        // Step 2: Find the membership by code
        $membership = Membership::where('membership_code', $request->membership_code)
                                ->with(['user', 'area', 'plan'])
                                ->first();

        // Step 3: Check if membership exists
        if (!$membership) {
            return back()->with('error', 'Invalid membership code!');
        }

        // Step 4: Check if membership is active
        if ($membership->status !== 'active') {
            return back()->with('error', 'This membership is not active!');
        }

        // Step 5: Check if membership is expired
        if ($membership->end_date < now()->toDateString()) {
            // Update status to expired
            $membership->update(['status' => 'expired']);
            return back()->with('error', 'This membership has expired!');
        }

        // Step 6: Check if membership area matches gym area
        if ($membership->area_id !== $gym->area_id) {
            return back()->with('error', 'This membership is not valid for this area!');
        }

        // Step 7: All checks passed - log the visit
        VisitLog::create([
            'membership_id' => $membership->id,
            'gym_id'        => $gym->id,
            'visit_date'    => now()->toDateString(),
        ]);

        return back()->with('success',
            'Access Granted! Welcome ' . $membership->user->name . '!');
    }

    /*
    | visitLogs() - Show all visits for this gym
    */
    public function visitLogs()
    {
        // Get the gym of this owner
        $gym = Gym::where('owner_id', Auth::id())->first();

        $visitLogs = collect(); // empty collection by default

        if ($gym) {
            // Get all visit logs for this gym with membership and user details
            $visitLogs = VisitLog::where('gym_id', $gym->id)
                                 ->with(['membership.user', 'membership.plan'])
                                 ->orderBy('visit_date', 'desc')
                                 ->get();
        }

        return view('gymowner.visit-logs', compact('visitLogs', 'gym'));
    }
}