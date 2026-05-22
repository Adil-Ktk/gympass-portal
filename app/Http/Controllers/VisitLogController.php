<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitLog;
use App\Models\Gym;

/*
|--------------------------------------------------------------------------
| VisitLogController
|--------------------------------------------------------------------------
| This controller handles visit logs for Admin.
| Admin can view all visit logs across all gyms.
*/

class VisitLogController extends Controller
{
    /*
    | index() - Show all visit logs
    | Admin sees all visits across all gyms
    */
    public function index()
    {
        // Get all visit logs with related gym, membership, and user details
        $visitLogs = VisitLog::with([
                                'gym',
                                'membership.user',
                                'membership.plan',
                                'membership.area'
                             ])
                             ->orderBy('visit_date', 'desc')
                             ->get();

        return view('admin.visit-logs', compact('visitLogs'));
    }
}