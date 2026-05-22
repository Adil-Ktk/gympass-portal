{{-- 
|--------------------------------------------------------------------------
| Register Page
|--------------------------------------------------------------------------
| This page allows new users to create an account.
| After registration, user is automatically logged in
| and redirected to their dashboard.
--}}

{{-- Extend the master layout (navbar + structure) --}}
@extends('layouts.app')

{{-- Page title shown in browser tab --}}
@section('title', 'Register - GymPass Portal')

{{-- Main content of this page --}}
@section('content')

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">

            {{-- Registration Card --}}
            <div class="card shadow-lg border-0 rounded-4">

                {{-- Card Header --}}
                <div class="card-header bg-dark text-white text-center py-4">
                    <h3 class="mb-0">
                        {{-- Trophy icon from Bootstrap Icons --}}
                        <i class="bi bi-trophy-fill text-warning"></i>
                        GymPass Portal
                    </h3>
                    <small class="text-muted">Create your account</small>
                </div>

                {{-- Card Body - Contains the form --}}
                <div class="card-body p-4">

                    {{-- 
                    | ERROR MESSAGES SECTION
                    | Shows validation errors if form submission fails.
                    | Example: "Email already taken", "Password too short"
                    --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div>
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $error }}
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- 
                    | REGISTRATION FORM
                    | action = where to send form data (register.post route)
                    | method = POST because we are sending data
                    --}}
                    <form action="{{ route('register.post') }}" method="POST">

                        {{-- 
                        | CSRF TOKEN
                        | Required by Laravel for security.
                        | Prevents fake form submissions from other websites.
                        --}}
                        @csrf

                        {{-- Full Name Field --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-person"></i> Full Name
                            </label>
                            <input
                                type="text"
                                name="name"
                                class="form-control form-control-lg"
                                placeholder="Enter your full name"
                                value="{{ old('name') }}"
                                required>
                            {{-- 
                            | old('name') keeps the value if form fails.
                            | So user doesn't have to retype everything.
                            --}}
                        </div>

                        {{-- Email Address Field --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-envelope"></i> Email Address
                            </label>
                            <input
                                type="email"
                                name="email"
                                class="form-control form-control-lg"
                                placeholder="Enter your email"
                                value="{{ old('email') }}"
                                required>
                        </div>

                        {{-- Password Field --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <input
                                type="password"
                                name="password"
                                class="form-control form-control-lg"
                                placeholder="Minimum 6 characters"
                                required>
                        </div>

                        {{-- Confirm Password Field --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-lock-fill"></i> Confirm Password
                            </label>
                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control form-control-lg"
                                placeholder="Repeat your password"
                                required>
                            {{-- 
                            | name must be "password_confirmation"
                            | Laravel automatically checks if it matches
                            | the password field when we use 'confirmed' rule.
                            --}}
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-dark btn-lg">
                                <i class="bi bi-person-plus"></i> Create Account
                            </button>
                        </div>

                    </form>

                </div>

                {{-- Card Footer - Link to login page --}}
                <div class="card-footer text-center py-3 bg-light">
                    <small>
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-primary fw-bold">
                            Login here
                        </a>
                    </small>
                </div>

            </div>
            {{-- End of Registration Card --}}

        </div>
    </div>
</div>

@endsection