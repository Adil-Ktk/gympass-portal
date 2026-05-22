<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Area Model
|--------------------------------------------------------------------------
| This model represents the 'areas' table in the database.
| Areas are cities/locations like Islamabad, Rawalpindi, DHA, Bahria.
| A membership is purchased for a specific area.
*/

class Area extends Model
{
    /*
    | $fillable tells Laravel which columns are allowed to be
    | filled when creating or updating a record.
    | We only have 'name' column in areas table.
    */
    protected $fillable = ['name'];

    /*
    | RELATIONSHIP: One Area has Many Gyms
    | Example: Islamabad area has multiple gyms inside it.
    | This lets us do: $area->gyms to get all gyms in that area.
    */
    public function gyms()
    {
        return $this->hasMany(Gym::class);
    }

    /*
    | RELATIONSHIP: One Area has Many Memberships
    | Example: Many users can buy membership for Islamabad area.
    | This lets us do: $area->memberships to get all memberships.
    */
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }
}