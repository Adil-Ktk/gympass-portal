{{--
|--------------------------------------------------------------------------
| Admin - Gym Owners Page
|--------------------------------------------------------------------------
| Shows only gym owners.
--}}

@extends('layouts.app')

@section('title', 'Gym Owners - GymPass Portal')

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

        {{-- MAIN CONTENT --}}
        <div class="col-md-10 main-content">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">
                    <i class="bi bi-person-badge text-dark"></i> Gym Owners
                </h2>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Gym Owner
                </a>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Gym Owners Table --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gym</th>
                                <th>Area</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($gymOwners as $owner)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <i class="bi bi-person-badge text-success"></i>
                                        {{ $owner->name }}
                                    </td>
                                    <td>{{ $owner->email }}</td>
                                    <td>
                                        {{-- Show gym name if assigned --}}
                                        @if($owner->gym)
                                            <span class="badge bg-success">
                                                {{ $owner->gym->gym_name }}
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                No gym assigned
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- Show area if gym assigned --}}
                                        @if($owner->gym)
                                            <span class="badge bg-info text-dark">
                                                {{ $owner->gym->area->name }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $owner->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $owner->id) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $owner->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this gym owner?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-1"></i>
                                        <br>No gym owners found.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection