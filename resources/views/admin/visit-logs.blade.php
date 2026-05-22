{{--
|--------------------------------------------------------------------------
| Admin - Visit Logs Page
|--------------------------------------------------------------------------
| Shows all gym visits across all gyms.
| Admin can see who visited which gym and on what date.
--}}

@extends('layouts.app')

@section('title', 'Visit Logs - GymPass Portal')

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
            <a href="{{ route('admin.users.index') }}"
               class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Members
            </a>
            <a href="{{ route('admin.gymowners.index') }}"
               class="{{ request()->routeIs('admin.gymowners*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> Gym Owners
            </a>
            <a href="{{ route('admin.memberships.index') }}"
               class="{{ request()->routeIs('admin.memberships*') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i> Memberships
            </a>
            <a href="{{ route('admin.visit.logs') }}"
               class="{{ request()->routeIs('admin.visit*') ? 'active' : '' }}">
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
            <div class="mb-4">
                <h2 class="fw-bold">
                    <i class="bi bi-journal-text text-primary"></i> Visit Logs
                </h2>
                <small class="text-muted">
                    All gym visits across all areas
                </small>
            </div>

            {{-- Visit Logs Table --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Member Name</th>
                                <th>Membership Code</th>
                                <th>Gym</th>
                                <th>Area</th>
                                <th>Plan</th>
                                <th>Visit Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($visitLogs as $log)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <i class="bi bi-person-circle text-primary"></i>
                                        {{-- Get user name through membership --}}
                                        {{ $log->membership->user->name }}
                                    </td>
                                    <td>
                                        <span class="badge bg-dark">
                                            {{ $log->membership->membership_code }}
                                        </span>
                                    </td>
                                    <td>
                                        <i class="bi bi-building text-success"></i>
                                        {{ $log->gym->gym_name }}
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $log->membership->area->name }}
                                        </span>
                                    </td>
                                    <td>{{ $log->membership->plan->plan_name }}</td>
                                    <td>
                                        <i class="bi bi-calendar text-warning"></i>
                                        {{ \Carbon\Carbon::parse($log->visit_date)->format('d M Y') }}
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-1"></i>
                                        <br>No visit logs found yet.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        {{-- END MAIN CONTENT --}}

    </div>
</div>

@endsection