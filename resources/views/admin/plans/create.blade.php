{{--
|--------------------------------------------------------------------------
| Admin - Create Plan Page
|--------------------------------------------------------------------------
| Form to add a new membership plan.
--}}

@extends('layouts.app')

@section('title', 'Add Plan - GymPass Portal')

@section('content')

<div class="container-fluid">
    <div class="row">

        {{-- SIDEBAR --}}
        <div class="col-md-2 sidebar p-0">
            <div class="p-3 text-white text-center border-bottom border-secondary">
                <i class="bi bi-person-circle fs-1"></i>
                <div class="small mt-1">{{ Auth::user()->name }}</div>
                <span class="badge bg-warning text-dark">Admin</span>
            </div>

            <a href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.areas.index') }}">
                <i class="bi bi-geo-alt"></i> Areas
            </a>
            <a href="{{ route('admin.plans.index') }}" class="active">
                <i class="bi bi-card-list"></i> Plans
            </a>
            <a href="{{ route('admin.gyms.index') }}">
                <i class="bi bi-building"></i> Gyms
            </a>
            <a href="{{ route('admin.users.index') }}">
                <i class="bi bi-people"></i> Members
            </a>
            <a href="{{ route('admin.gymowners.index') }}">
                <i class="bi bi-person-badge"></i> Gym Owners
            </a>
            <a href="{{ route('admin.memberships.index') }}">
                <i class="bi bi-credit-card"></i> Memberships
            </a>
            <a href="{{ route('admin.visit.logs') }}">
                <i class="bi bi-journal-text"></i> Visit Logs
            </a>

            <form action="{{ route('logout') }}" method="POST" class="px-3 mt-3">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
        {{-- END SIDEBAR --}}

        {{-- MAIN CONTENT --}}
        <div class="col-md-10 main-content">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">
                    <i class="bi bi-plus-circle text-primary"></i> Add New Plan
                </h2>
                <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Plans
                </a>
            </div>

            {{-- Create Plan Form --}}
            <div class="card shadow-sm">
                <div class="card-body p-4">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div><i class="bi bi-exclamation-circle"></i> {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('admin.plans.store') }}" method="POST">
                        @csrf

                        {{-- Plan Name --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-card-list"></i> Plan Name
                            </label>
                            <input
                                type="text"
                                name="plan_name"
                                class="form-control form-control-lg"
                                placeholder="e.g. Monthly Plan, Weekly Plan"
                                value="{{ old('plan_name') }}"
                                required>
                        </div>

                        {{-- Duration Days --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-calendar"></i> Duration (Days)
                            </label>
                            <input
                                type="number"
                                name="duration_days"
                                class="form-control form-control-lg"
                                placeholder="e.g. 30 for monthly, 7 for weekly"
                                value="{{ old('duration_days') }}"
                                min="1"
                                required>
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-currency-dollar"></i> Price (Rs.)
                            </label>
                            <input
                                type="number"
                                name="price"
                                class="form-control form-control-lg"
                                placeholder="e.g. 2000"
                                value="{{ old('price') }}"
                                min="0"
                                step="0.01"
                                required>
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Save Plan
                            </button>
                            <a href="{{ route('admin.plans.index') }}"
                               class="btn btn-secondary btn-lg">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
        {{-- END MAIN CONTENT --}}

    </div>
</div>

@endsection