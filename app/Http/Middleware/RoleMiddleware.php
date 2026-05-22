<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| RoleMiddleware
|--------------------------------------------------------------------------
| This middleware checks if the logged in user has the correct role
| before allowing access to a route.
|
| Usage in routes:
| middleware('role:admin')     → only admin can access
| middleware('role:gym_owner') → only gym owner can access
| middleware('role:user')      → only user can access
*/

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')
                             ->with('error', 'Please login first.');
        }

        // Check if user has the required role
        if (Auth::user()->role !== $role) {
            return redirect()->route('login')
                             ->with('error', 'You do not have permission to access this page.');
        }

        // User has correct role - allow access
        return $next($request);
    }
}