<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gym;
use App\Models\Area;
use App\Models\Plan;
use App\Models\Membership;
use App\Models\VisitLog;

/*
|--------------------------------------------------------------------------
| AdminController
|--------------------------------------------------------------------------
| This controller handles the Admin dashboard.
| Admin can see overview stats of the entire system.
*/

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | dashboard()
    |--------------------------------------------------------------------------
    | Shows the admin dashboard with system statistics.
    | Admin can see total counts of users, gyms, plans, memberships.
    */
    public function dashboard()
    {
        // Count total users (only role = 'user')
        $totalUsers = User::where('role', 'user')->count();

        // Count total gym owners
        $totalGymOwners = User::where('role', 'gym_owner')->count();

        // Count total gyms
        $totalGyms = Gym::count();

        // Count total areas
        $totalAreas = Area::count();

        // Count total plans
        $totalPlans = Plan::count();

        // Count total memberships
        $totalMemberships = Membership::count();

        // Count active memberships
        $activeMemberships = Membership::where('status', 'active')->count();

        // Count total visits
        $totalVisits = VisitLog::count();

        // Send all data to the dashboard view
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalGymOwners',
            'totalGyms',
            'totalAreas',
            'totalPlans',
            'totalMemberships',
            'activeMemberships',
            'totalVisits'
        ));
    }
}