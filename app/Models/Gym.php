<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Gym Model
|--------------------------------------------------------------------------
| This model represents the 'gyms' table in the database.
| Each gym belongs to an area and has an owner (gym_owner user).
| Gym owners can verify memberships and log visits.
*/

class Gym extends Model
{
    /*
    | $fillable lists all columns that can be filled.
    | owner_id = the user who owns this gym (gym_owner role)
    | area_id  = which area this gym belongs to
    | gym_name = name of the gym
    | address  = physical address of the gym
    */
    protected $fillable = [
        'owner_id',
        'area_id',
        'gym_name',
        'address'
    ];

    /*
    | RELATIONSHIP: Gym belongs to an Area
    | Example: FitZone gym belongs to Islamabad area.
    | This lets us do: $gym->area to get the area of this gym.
    */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    /*
    | RELATIONSHIP: Gym belongs to an Owner (User)
    | The owner is a user with role = 'gym_owner'.
    | We specify 'owner_id' as the foreign key.
    | This lets us do: $gym->owner to get the owner details.
    */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /*
    | RELATIONSHIP: Gym has Many Visit Logs
    | Every time a member visits this gym, a log is created.
    | This lets us do: $gym->visitLogs to get all visits.
    */
    public function visitLogs()
    {
        return $this->hasMany(VisitLog::class);
    }
}