{{--
|--------------------------------------------------------------------------
| Admin - Gyms Index Page
|--------------------------------------------------------------------------
| Shows all gyms in a table.
| Admin can add, edit or delete gyms.
| Each gym shows its area and owner name.
--}}

@extends('layouts.app')

@section('title', 'Manage Gyms - GymPass Portal')

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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">
                    <i class="bi bi-building text-primary"></i> Manage Gyms
                </h2>
                <a href="{{ route('admin.gyms.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Gym
                </a>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Gyms Table --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Gym Name</th>
                                <th>Area</th>
                                <th>Owner</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($gyms as $gym)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <i class="bi bi-building text-primary"></i>
                                        {{ $gym->gym_name }}
                                    </td>
                                    <td>
                                        {{-- Show area name --}}
                                        <span class="badge bg-info text-dark">
                                            {{ $gym->area->name }}
                                        </span>
                                    </td>
                                    <td>
                                        {{-- Show owner name --}}
                                        <i class="bi bi-person"></i>
                                        {{ $gym->owner->name }}
                                    </td>
                                    <td>{{ $gym->address }}</td>
                                    <td>
                                        {{-- Edit Button --}}
                                        <a href="{{ route('admin.gyms.edit', $gym->id) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('admin.gyms.destroy', $gym->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this gym?')">
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
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-1"></i>
                                        <br>No gyms found. Add your first gym!
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