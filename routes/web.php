<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\GymOwnerController;
use App\Http\Controllers\VisitLogController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES - GymPass Portal
|--------------------------------------------------------------------------
| All routes for the GymPass Portal system.
| Organized by: Public Routes, Auth Routes, User Routes,
|               Gym Owner Routes, Admin Routes
*/

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
| These routes are accessible without login.
*/

// Home page - redirects to login
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
| Register, Login, Logout routes for all roles.
*/

// Show login form
Route::get('/login', [AuthController::class, 'showLoginForm'])
     ->name('login');

// Process login form
Route::post('/login', [AuthController::class, 'login'])
     ->name('login.post');

// Show register form
Route::get('/register', [AuthController::class, 'showRegisterForm'])
     ->name('register');

// Process register form
Route::post('/register', [AuthController::class, 'register'])
     ->name('register.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
     ->name('logout');

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
| These routes are for logged in users with role = 'user'.
| auth = must be logged in
| role:user = must have user role
| Prefix: /user
*/

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {

    // User dashboard
    Route::get('/dashboard', [MembershipController::class, 'index'])
         ->name('user.dashboard');

    // Show buy membership page
    Route::get('/buy-membership', [MembershipController::class, 'create'])
         ->name('user.buy.membership');

    // Process membership purchase
    Route::post('/buy-membership', [MembershipController::class, 'store'])
         ->name('user.membership.store');

    // Show digital membership card
    Route::get('/membership', [MembershipController::class, 'show'])
         ->name('user.membership');

});

/*
|--------------------------------------------------------------------------
| GYM OWNER ROUTES
|--------------------------------------------------------------------------
| These routes are for logged in users with role = 'gym_owner'.
| auth = must be logged in
| role:gym_owner = must have gym_owner role
| Prefix: /gymowner
*/

Route::middleware(['auth', 'role:gym_owner'])->prefix('gymowner')->group(function () {

    // Gym owner dashboard
    Route::get('/dashboard', [GymOwnerController::class, 'dashboard'])
         ->name('gymowner.dashboard');

    // Show verify membership form
    Route::get('/verify', [GymOwnerController::class, 'verifyForm'])
         ->name('gymowner.verify');

    // Process membership verification
    Route::post('/verify', [GymOwnerController::class, 'verify'])
         ->name('gymowner.verify.post');

    // View visit logs for this gym
    Route::get('/visit-logs', [GymOwnerController::class, 'visitLogs'])
         ->name('gymowner.visit.logs');

});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
| These routes are for logged in users with role = 'admin'.
| auth = must be logged in
| role:admin = must have admin role
| Prefix: /admin
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Admin dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
         ->name('admin.dashboard');

    // ----- AREAS CRUD -----
    // Show all areas
    Route::get('/areas', [AreaController::class, 'index'])
         ->name('admin.areas.index');

    // Show create area form
    Route::get('/areas/create', [AreaController::class, 'create'])
         ->name('admin.areas.create');

    // Save new area
    Route::post('/areas', [AreaController::class, 'store'])
         ->name('admin.areas.store');

    // Show edit area form
    Route::get('/areas/{id}/edit', [AreaController::class, 'edit'])
         ->name('admin.areas.edit');

    // Update area
    Route::put('/areas/{id}', [AreaController::class, 'update'])
         ->name('admin.areas.update');

    // Delete area
    Route::delete('/areas/{id}', [AreaController::class, 'destroy'])
         ->name('admin.areas.destroy');

    // ----- PLANS CRUD -----
    // Show all plans
    Route::get('/plans', [PlanController::class, 'index'])
         ->name('admin.plans.index');

    // Show create plan form
    Route::get('/plans/create', [PlanController::class, 'create'])
         ->name('admin.plans.create');

    // Save new plan
    Route::post('/plans', [PlanController::class, 'store'])
         ->name('admin.plans.store');

    // Show edit plan form
    Route::get('/plans/{id}/edit', [PlanController::class, 'edit'])
         ->name('admin.plans.edit');

    // Update plan
    Route::put('/plans/{id}', [PlanController::class, 'update'])
         ->name('admin.plans.update');

    // Delete plan
    Route::delete('/plans/{id}', [PlanController::class, 'destroy'])
         ->name('admin.plans.destroy');

    // ----- GYMS CRUD -----
    // Show all gyms
    Route::get('/gyms', [GymController::class, 'index'])
         ->name('admin.gyms.index');

    // Show create gym form
    Route::get('/gyms/create', [GymController::class, 'create'])
         ->name('admin.gyms.create');

    // Save new gym
    Route::post('/gyms', [GymController::class, 'store'])
         ->name('admin.gyms.store');

    // Show edit gym form
    Route::get('/gyms/{id}/edit', [GymController::class, 'edit'])
         ->name('admin.gyms.edit');

    // Update gym
    Route::put('/gyms/{id}', [GymController::class, 'update'])
         ->name('admin.gyms.update');

    // Delete gym
    Route::delete('/gyms/{id}', [GymController::class, 'destroy'])
         ->name('admin.gyms.destroy');

    // ----- USERS MANAGEMENT -----
    // Show all users
    Route::get('/users', [UserController::class, 'index'])
         ->name('admin.users.index');

     // Show all gym owners
     Route::get('/gymowners', [UserController::class, 'gymOwners'])
          ->name('admin.gymowners.index');
          
    // Show create user form
    Route::get('/users/create', [UserController::class, 'create'])
         ->name('admin.users.create');

    // Save new user
    Route::post('/users', [UserController::class, 'store'])
         ->name('admin.users.store');

    // Show edit user form
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])
         ->name('admin.users.edit');

    // Update user
    Route::put('/users/{id}', [UserController::class, 'update'])
         ->name('admin.users.update');

    // Delete user
    Route::delete('/users/{id}', [UserController::class, 'destroy'])
         ->name('admin.users.destroy');

    // ----- VISIT LOGS -----
    // View all visit logs
    Route::get('/visit-logs', [VisitLogController::class, 'index'])
         ->name('admin.visit.logs');
     
     // ----- MEMBERSHIPS -----
     // View all memberships
     Route::get('/memberships', [MembershipController::class, 'adminIndex'])
          ->name('admin.memberships.index');

     // View single membership card
     Route::get('/memberships/{id}', [MembershipController::class, 'adminShow'])
          ->name('admin.memberships.show');

});