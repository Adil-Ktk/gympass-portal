{{-- This page extends the master layout --}}
@extends('layouts.app')

{{-- Page content goes inside @section('content') --}}
@section('content')

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">

            {{-- Login Card --}}
            <div class="card shadow-lg border-0 rounded-4">

                {{-- Card Header --}}
                <div class="card-header bg-dark text-white text-center py-4 rounded-top-4">
                    <h3 class="mb-0">
                        <i class="bi bi-trophy-fill text-warning"></i>
                        GymPass Portal
                    </h3>
                    <small class="text-muted">Sign in to your account</small>
                </div>

                {{-- Card Body --}}
                <div class="card-body p-4">

                    {{-- Show error messages --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Show success message --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Login Form --}}
                    <form action="{{ route('login.post') }}" method="POST">

                        {{-- CSRF token for security --}}
                        @csrf

                        {{-- Email Field --}}
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
                                placeholder="Enter your password"
                                required>
                        </div>

                        {{-- Login Button --}}
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-dark btn-lg">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>
                        </div>

                    </form>

                </div>

                {{-- Card Footer --}}
                <div class="card-footer text-center py-3 bg-light">
                    <small>
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-primary fw-bold">
                            Register here
                        </a>
                    </small>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection