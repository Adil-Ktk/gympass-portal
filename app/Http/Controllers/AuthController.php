<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| AuthController
|--------------------------------------------------------------------------
| This controller handles all authentication for our system.
| It manages: Register, Login, Logout
| It works for all 3 roles: admin, user, gym_owner
*/

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | showRegisterForm()
    |--------------------------------------------------------------------------
    | This method shows the registration page.
    | When user visits /register, this method runs.
    */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /*
    |--------------------------------------------------------------------------
    | register()
    |--------------------------------------------------------------------------
    | This method runs when user submits the registration form.
    | It validates the data, creates the user, logs them in,
    | and redirects them to their dashboard based on their role.
    */
    public function register(Request $request)
    {
        // Step 1: Validate the form data
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            // 'role' is not in form - regular users always register as 'user'
        ]);

        // Step 2: Create the new user in the database
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // encrypt password
            'role'     => 'user', // all self-registered users are 'user' role
        ]);

        // Step 3: Log the user in automatically after registration
        Auth::login($user);

        // Step 4: Redirect to user dashboard
        return redirect()->route('user.dashboard')
                         ->with('success', 'Registration successful! Welcome.');
    }

    /*
    |--------------------------------------------------------------------------
    | showLoginForm()
    |--------------------------------------------------------------------------
    | This method shows the login page.
    | When user visits /login, this method runs.
    */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | login()
    |--------------------------------------------------------------------------
    | This method runs when user submits the login form.
    | It checks the email and password.
    | If correct, it redirects based on the user's role.
    | If wrong, it sends back an error message.
    */
    public function login(Request $request)
    {
        // Step 1: Validate the form data
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Step 2: Try to login with email and password
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Login successful - get the logged in user
            $user = Auth::user();

            // Step 3: Redirect based on role
            if ($user->role === 'admin') {
                // Admin goes to admin dashboard
                return redirect()->route('admin.dashboard')
                                 ->with('success', 'Welcome Admin!');

            } elseif ($user->role === 'gym_owner') {
                // Gym owner goes to gym owner dashboard
                return redirect()->route('gymowner.dashboard')
                                 ->with('success', 'Welcome Gym Owner!');

            } else {
                // Regular user goes to user dashboard
                return redirect()->route('user.dashboard')
                                 ->with('success', 'Welcome ' . $user->name . '!');
            }
        }

        // Step 4: Login failed - go back with error
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | logout()
    |--------------------------------------------------------------------------
    | This method logs the user out.
    | It clears the session and redirects to login page.
    */
    public function logout(Request $request)
    {
        // Log the user out
        Auth::logout();

        // Clear the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to login page
        return redirect()->route('login')
                         ->with('success', 'You have been logged out successfully.');
    }
}