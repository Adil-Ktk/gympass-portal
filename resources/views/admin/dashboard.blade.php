{{--
|--------------------------------------------------------------------------
| Admin Dashboard Page
|--------------------------------------------------------------------------
| This page shows the admin an overview of the entire system.
| Admin can see total counts of users, gyms, plans, memberships, visits.
--}}

@extends('layouts.app')

@section('title', 'Admin Dashboard - GymPass Portal')

@section('content')

<div class="container-fluid">
    <div class="row">

        {{-- LEFT SIDEBAR --}}
        <div class="col-md-2 sidebar p-0">
            <div class="p-3 text-white text-center border-bottom border-secondary">
                <i class="bi bi-person-circle fs-1"></i>
                <div class="small mt-1">{{ Auth::user()->name }}</div>
                <span class="badge bg-warning text-dark">Admin</span>
            </div>

            <a href="{{ route('admin.memberships.index') }}"
                class="{{ request()->routeIs('admin.memberships*') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i> Memberships
            </a>

            {{-- Sidebar Navigation Links --}}
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a href="{{ route('admin.areas.index') }}"
               class="{{ request()->routeIs('admin.areas*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt"></i> Areas
            </a>

            <a href="{{ route('admin.plans.index') }}"
               class="{{ request()->routeIs('admin.plans*') ? 'active' : '' }}">
                <i class="bi bi-card-list"></i> Plans
            </a>

            <a href="{{ route('admin.gyms.index') }}"
               class="{{ request()->routeIs('admin.gyms*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> Gyms
            </a>

            <a href="{{ route('admin.users.index') }}">
                <i class="bi bi-people"></i> Members
            </a>
            <a href="{{ route('admin.gymowners.index') }}">
                <i class="bi bi-person-badge"></i> Gym Owners
            </a>

            <a href="{{ route('admin.visit.logs') }}"
               class="{{ request()->routeIs('admin.visit*') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i> Visit Logs
            </a>

            {{-- Logout Form in Sidebar --}}
            <form action="{{ route('logout') }}" method="POST" class="px-3 mt-3">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
        {{-- END SIDEBAR --}}

        {{-- MAIN CONTENT AREA --}}
        <div class="col-md-10 main-content">

            {{-- Page Title --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">
                    <i class="bi bi-speedometer2 text-primary"></i>
                    Admin Dashboard
                </h2>
                <small class="text-muted">Welcome back, {{ Auth::user()->name }}!</small>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- STATISTICS CARDS ROW --}}
            <div class="row g-4 mb-4">

                {{-- Total Users Card --}}
                <div class="col-md-3">
                    <div class="card stat-card bg-primary text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $totalUsers }}</div>
                                <div>Total Members</div>
                            </div>
                            <i class="bi bi-people fs-1 opacity-50"></i>
                        </div>
                        <div class="card-footer bg-primary border-0">
                            <a href="{{ route('admin.users.index') }}"
                               class="text-white text-decoration-none small">
                                View all members →
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Total Gyms Card --}}
                <div class="col-md-3">
                    <div class="card stat-card bg-success text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $totalGyms }}</div>
                                <div>Total Gyms</div>
                            </div>
                            <i class="bi bi-building fs-1 opacity-50"></i>
                        </div>
                        <div class="card-footer bg-success border-0">
                            <a href="{{ route('admin.gyms.index') }}"
                               class="text-white text-decoration-none small">
                                View all gyms →
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Active Memberships Card --}}
                <div class="col-md-3">
                    <div class="card stat-card bg-warning text-dark">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $activeMemberships }}</div>
                                <div>Active Memberships</div>
                            </div>
                            <i class="bi bi-card-checklist fs-1 opacity-50"></i>
                        </div>
                        <div class="card-footer bg-warning border-0">
                            <a href="{{ route('admin.memberships.index') }}"
                                class="text-dark text-decoration-none small">
                                View all memberships →
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Total Visits Card --}}
                <div class="col-md-3">
                    <div class="card stat-card bg-info text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $totalVisits }}</div>
                                <div>Total Visits</div>
                            </div>
                            <i class="bi bi-journal-check fs-1 opacity-50"></i>
                        </div>
                        <div class="card-footer bg-info border-0">
                            <a href="{{ route('admin.visit.logs') }}"
                               class="text-white text-decoration-none small">
                                View all logs →
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            {{-- END STATISTICS CARDS --}}

            {{-- SECOND ROW OF CARDS --}}
            <div class="row g-4">

                {{-- Areas Card --}}
                <div class="col-md-3">
                    <div class="card stat-card bg-secondary text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $totalAreas }}</div>
                                <div>Total Areas</div>
                            </div>
                            <i class="bi bi-geo-alt fs-1 opacity-50"></i>
                        </div>
                        <div class="card-footer bg-secondary border-0">
                            <a href="{{ route('admin.areas.index') }}"
                               class="text-white text-decoration-none small">
                                Manage areas →
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Plans Card --}}
                <div class="col-md-3">
                    <div class="card stat-card bg-danger text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $totalPlans }}</div>
                                <div>Total Plans</div>
                            </div>
                            <i class="bi bi-card-list fs-1 opacity-50"></i>
                        </div>
                        <div class="card-footer bg-danger border-0">
                            <a href="{{ route('admin.plans.index') }}"
                               class="text-white text-decoration-none small">
                                Manage plans →
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Gym Owners Card --}}
                <div class="col-md-3">
                    <div class="card stat-card bg-dark text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $totalGymOwners }}</div>
                                <div>Gym Owners</div>
                            </div>
                            <i class="bi bi-person-badge fs-1 opacity-50"></i>
                        </div>
                        <div class="card-footer bg-dark border-0">
                            <a href="{{ route('admin.gymowners.index') }}"
                                class="text-white text-decoration-none small">
                                Manage owners →
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            {{-- END SECOND ROW --}}

        </div>
        {{-- END MAIN CONTENT --}}

    </div>
</div>

@endsection