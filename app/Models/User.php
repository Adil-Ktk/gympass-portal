<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/*
|--------------------------------------------------------------------------
| User Model
|--------------------------------------------------------------------------
| This model represents the 'users' table in the database.
| In our system, users have 3 roles:
|   - 'admin'     = manages the entire system
|   - 'user'      = purchases memberships and visits gyms
|   - 'gym_owner' = verifies memberships and tracks visits
*/

class User extends Authenticatable
{
    /*
    | HasFactory = allows creating fake users for testing
    | Notifiable = allows sending notifications to users
    */
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /*
    |--------------------------------------------------------------------------
    | $fillable
    |--------------------------------------------------------------------------
    | These are the columns that can be filled when creating
    | or updating a user record.
    | We added 'role' so we can assign admin/user/gym_owner
    | when registering or creating users.
    */
    protected $fillable = [
        'name',      // Full name of the user
        'email',     // Email address (used for login)
        'password',  // Password (automatically hashed by Laravel)
        'role',      // Role: 'admin', 'user', or 'gym_owner'
    ];

    /*
    |--------------------------------------------------------------------------
    | $hidden
    |--------------------------------------------------------------------------
    | These columns will NOT be shown when user data is
    | converted to JSON or array.
    | We hide password and remember_token for security reasons.
    */
    protected $hidden = [
        'password',       // Never expose password in responses
        'remember_token', // Used for "remember me" login feature
    ];

    /*
    |--------------------------------------------------------------------------
    | casts()
    |--------------------------------------------------------------------------
    | Casts automatically convert column values to specific data types.
    | 'email_verified_at' is converted to a datetime object.
    | 'password' is automatically hashed when saved.
    */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP: User has one Membership
    |--------------------------------------------------------------------------
    | A user can purchase a membership.
    | This lets us do: $user->membership to get their membership.
    */
    public function membership()
    {
        return $this->hasOne(Membership::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP: User has one Gym (as Gym Owner)
    |--------------------------------------------------------------------------
    | If this user is a gym_owner, they own one gym.
    | This lets us do: $user->gym to get the gym they own.
    */
    public function gym()
    {
        return $this->hasOne(Gym::class, 'owner_id');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: Check if user is Admin
    |--------------------------------------------------------------------------
    | Returns true if this user's role is 'admin'.
    | Usage: if ($user->isAdmin()) { ... }
    */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: Check if user is Gym Owner
    |--------------------------------------------------------------------------
    | Returns true if this user's role is 'gym_owner'.
    | Usage: if ($user->isGymOwner()) { ... }
    */
    public function isGymOwner()
    {
        return $this->role === 'gym_owner';
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: Check if user is a regular User
    |--------------------------------------------------------------------------
    | Returns true if this user's role is 'user'.
    | Usage: if ($user->isUser()) { ... }
    */
    public function isUser()
    {
        return $this->role === 'user';
    }
}