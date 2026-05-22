<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Membership;
use App\Models\Area;
use App\Models\Plan;

/*
|--------------------------------------------------------------------------
| MembershipController
|--------------------------------------------------------------------------
| This controller handles membership purchase for Users.
| User can: Select area, select plan, buy membership.
| System generates a unique membership code automatically.
*/

class MembershipController extends Controller
{
    /*
    | index() - Show user dashboard with membership details
    */
    public function index()
    {
        // Get the logged in user's membership
        $membership = Membership::where('user_id', Auth::id())
                                ->with(['area', 'plan'])
                                ->first();

        return view('user.dashboard', compact('membership'));
    }

    /*
    | create() - Show buy membership page
    | User selects area and plan here
    */
    public function create()
    {
        // Check if user already has an active membership
        $existing = Membership::where('user_id', Auth::id())
                              ->where('status', 'active')
                              ->first();

        if ($existing) {
            return redirect()->route('user.membership')
                             ->with('error', 'You already have an active membership!');
        }

        // Get all areas and plans for dropdowns
        $areas = Area::all();
        $plans = Plan::all();

        return view('user.buy-membership', compact('areas', 'plans'));
    }

    /*
    | store() - Process membership purchase
    | Generates unique code and saves membership
    */
    public function store(Request $request)
    {
        $request->validate([
            'area_id' => 'required|exists:areas,id',
            'plan_id' => 'required|exists:plans,id',
        ]);

        // Get the selected plan to calculate end date
        $plan = Plan::findOrFail($request->plan_id);

        // Calculate start and end dates
        $startDate = now()->toDateString();
        $endDate   = now()->addDays($plan->duration_days)->toDateString();

        // Generate unique membership code e.g. GYM-AB12CD34
        $code = 'GYM-' . strtoupper(Str::random(8));

        // Save membership to database
        Membership::create([
            'user_id'         => Auth::id(),
            'area_id'         => $request->area_id,
            'plan_id'         => $request->plan_id,
            'membership_code' => $code,
            'start_date'      => $startDate,
            'end_date'        => $endDate,
            'status'          => 'active',
        ]);

        return redirect()->route('user.membership')
                         ->with('success', 'Membership purchased successfully!');
    }

    /*
    | show() - Show digital membership card
    */
    public function show()
    {
        // Get logged in user's membership with related data
        $membership = Membership::where('user_id', Auth::id())
                                ->with(['area', 'plan'])
                                ->first();

        if (!$membership) {
            return redirect()->route('user.buy.membership')
                             ->with('error', 'You do not have a membership yet!');
        }

        return view('user.membership-card', compact('membership'));
    }

    /*
    |--------------------------------------------------------------------------
    | adminIndex() - Show all memberships for admin
    |--------------------------------------------------------------------------
    | Admin can see all memberships of all users.
    */
    public function adminIndex()
    {
        // Get all memberships with user, area and plan details
        $memberships = Membership::with(['user', 'area', 'plan'])
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('admin.memberships.index', compact('memberships'));
    }

    /*
    | adminShow() - Show single membership card for admin
    |--------------------------------------------------------------------------
    | Admin can view any user's membership card.
    */
    public function adminShow(string $id)
    {
        // Find membership with all related data
        $membership = Membership::with(['user', 'area', 'plan'])
                                ->findOrFail($id);

        return view('admin.memberships.show', compact('membership'));
    }
}