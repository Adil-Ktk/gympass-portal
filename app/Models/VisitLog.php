<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| VisitLog Model
|--------------------------------------------------------------------------
| This model represents the 'visit_logs' table in the database.
| Every time a member visits a gym and their code is verified,
| a visit log record is created storing who visited which gym and when.
*/

class VisitLog extends Model
{
    /*
    | $fillable lists all columns that can be filled.
    | membership_id = which membership was used for this visit
    | gym_id        = which gym was visited
    | visit_date    = the date of the visit
    */
    protected $fillable = [
        'membership_id',
        'gym_id',
        'visit_date'
    ];

    /*
    | RELATIONSHIP: VisitLog belongs to a Membership
    | This tells us which member made this visit.
    | This lets us do: $visitLog->membership to get membership details.
    */
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    /*
    | RELATIONSHIP: VisitLog belongs to a Gym
    | This tells us which gym was visited.
    | This lets us do: $visitLog->gym to get gym details.
    */
    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}