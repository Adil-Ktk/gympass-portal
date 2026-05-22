{{--
|--------------------------------------------------------------------------
| Gym Owner Dashboard Page
|--------------------------------------------------------------------------
| Shows gym owner their gym info and total visits.
--}}

@extends('layouts.app')

@section('title', 'Gym Owner Dashboard - GymPass Portal')

@section('content')

<div class="container-fluid">
    <div class="row">

        {{-- SIDEBAR --}}
        <div class="col-md-2 sidebar p-0">
            <div class="p-3 text-white text-center border-bottom border-secondary">
                <i class="bi bi-person-circle fs-1"></i>
                <div class="small mt-1">{{ Auth::user()->name }}</div>
                <span class="badge bg-success">Gym Owner</span>
            </div>

            <a href="{{ route('gymowner.dashboard') }}"
               class="{{ request()->routeIs('gymowner.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('gymowner.verify') }}"
               class="{{ request()->routeIs('gymowner.verify') ? 'active' : '' }}">
                <i class="bi bi-qr-code-scan"></i> Verify Membership
            </a>
            <a href="{{ route('gymowner.visit.logs') }}"
               class="{{ request()->routeIs('gymowner.visit*') ? 'active' : '' }}">
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

            {{-- Page Title --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">
                    <i class="bi bi-speedometer2 text-success"></i>
                    Gym Owner Dashboard
                </h2>
                <small class="text-muted">
                    Welcome, {{ Auth::user()->name }}!
                </small>
            </div>

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Gym Info Card --}}
            @if($gym)
                <div class="row g-4 mb-4">

                    {{-- Gym Details Card --}}
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-building"></i> My Gym
                                </h5>
                            </div>
                            <div class="card-body">
                                <p>
                                    <strong>Gym Name:</strong>
                                    {{ $gym->gym_name }}
                                </p>
                                <p>
                                    <strong>Area:</strong>
                                    <span class="badge bg-info text-dark">
                                        {{ $gym->area->name }}
                                    </span>
                                </p>
                                <p>
                                    <strong>Address:</strong>
                                    {{ $gym->address }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Total Visits Card --}}
                    <div class="col-md-3">
                        <div class="card stat-card bg-primary text-white">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fs-2 fw-bold">{{ $totalVisits }}</div>
                                    <div>Total Visits</div>
                                </div>
                                <i class="bi bi-journal-check fs-1 opacity-50"></i>
                            </div>
                            <div class="card-footer bg-primary border-0">
                                <a href="{{ route('gymowner.visit.logs') }}"
                                   class="text-white text-decoration-none small">
                                    View all logs →
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Verify Button Card --}}
                    <div class="col-md-3">
                        <div class="card stat-card bg-success text-white">
                            <div class="card-body text-center py-4">
                                <i class="bi bi-qr-code-scan fs-1 mb-2"></i>
                                <div class="fw-bold">Verify Member</div>
                            </div>
                            <div class="card-footer bg-success border-0 text-center">
                                <a href="{{ route('gymowner.verify') }}"
                                   class="text-white text-decoration-none small">
                                    Verify now →
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            @else
                {{-- No gym assigned message --}}
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    No gym has been assigned to your account yet.
                    Please contact the admin.
                </div>
            @endif

        </div>
        {{-- END MAIN CONTENT --}}

    </div>
</div>

@endsection