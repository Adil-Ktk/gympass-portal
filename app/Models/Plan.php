<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Plan Model
|--------------------------------------------------------------------------
| This model represents the 'plans' table in the database.
| Plans are membership packages that users can purchase.
| Example: Monthly Plan = 30 days for Rs. 2000
*/

class Plan extends Model
{
    /*
    | $fillable lists all columns that can be filled.
    | plan_name     = name of the plan e.g. "Monthly Plan"
    | duration_days = how many days the plan lasts e.g. 30
    | price         = cost of the plan e.g. 2000.00
    */
    protected $fillable = [
        'plan_name',
        'duration_days',
        'price'
    ];

    /*
    | RELATIONSHIP: One Plan has Many Memberships
    | Example: Many users can purchase the "Monthly Plan".
    | This lets us do: $plan->memberships to get all memberships
    | that use this plan.
    */
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }
}