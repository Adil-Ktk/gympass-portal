<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Membership Model
|--------------------------------------------------------------------------
| This model represents the 'memberships' table in the database.
| When a user buys a plan for an area, a membership record is created.
| The membership has a unique code used for gym entry verification.
*/

class Membership extends Model
{
    /*
    | $fillable lists all columns that can be filled.
    | user_id         = which user owns this membership
    | area_id         = which area this membership is valid for
    | plan_id         = which plan was purchased
    | membership_code = unique code e.g. "GYM-AB12CD34"
    | start_date      = when membership starts
    | end_date        = when membership expires
    | status          = 'active' or 'expired'
    */
    protected $fillable = [
        'user_id',
        'area_id',
        'plan_id',
        'membership_code',
        'start_date',
        'end_date',
        'status'
    ];

    /*
    | RELATIONSHIP: Membership belongs to a User
    | Example: This membership belongs to Ali.
    | This lets us do: $membership->user to get user details.
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    | RELATIONSHIP: Membership belongs to an Area
    | Example: This membership is valid in Islamabad.
    | This lets us do: $membership->area to get area details.
    */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    /*
    | RELATIONSHIP: Membership belongs to a Plan
    | Example: This membership uses the "Monthly Plan".
    | This lets us do: $membership->plan to get plan details.
    */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /*
    | RELATIONSHIP: Membership has Many Visit Logs
    | Every time this member visits a gym, a log is stored.
    | This lets us do: $membership->visitLogs to see all visits.
    */
    public function visitLogs()
    {
        return $this->hasMany(VisitLog::class);
    }
}