{{--
|--------------------------------------------------------------------------
| Admin - View Membership Card Page
|--------------------------------------------------------------------------
| Admin can view any user's membership card.
--}}

@extends('layouts.app')

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
            <a href="{{ route('admin.plans.index') }}">
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
            <a href="{{ route('admin.memberships.index') }}" class="active">
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

        {{-- MAIN CONTENT --}}
        <div class="col-md-10 main-content">

            <div class="row justify-content-center">
                <div class="col-md-6">

                    {{-- Page Header --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold">
                            <i class="bi bi-credit-card text-primary"></i>
                            Membership Card
                        </h2>
                        <a href="{{ route('admin.memberships.index') }}"
                           class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>

                    {{-- DIGITAL MEMBERSHIP CARD --}}
                    <div class="membership-card mb-4">

                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h4 class="mb-0">
                                    <i class="bi bi-trophy-fill text-warning"></i>
                                    GymPass Portal
                                </h4>
                                <small class="opacity-75">Digital Membership Card</small>
                            </div>
                            @if($membership->status === 'active')
                                <span class="badge bg-success fs-6 px-3 py-2">
                                    <i class="bi bi-check-circle"></i> Active
                                </span>
                            @else
                                <span class="badge bg-danger fs-6 px-3 py-2">
                                    <i class="bi bi-x-circle"></i> Expired
                                </span>
                            @endif
                        </div>

                        {{-- Member Name --}}
                        <h3 class="mb-4">{{ $membership->user->name }}</h3>

                        {{-- Membership Code --}}
                        <div class="bg-white bg-opacity-25 rounded-3 p-3 mb-4 text-center">
                            <small class="opacity-75">Membership Code</small>
                            <h3 class="mb-0 fw-bold">
                                {{ $membership->membership_code }}
                            </h3>
                        </div>

                        {{-- Area and Plan --}}
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="opacity-75">Area</small>
                                <div class="fw-bold fs-5">{{ $membership->area->name }}</div>
                            </div>
                            <div class="col-6">
                                <small class="opacity-75">Plan</small>
                                <div class="fw-bold fs-5">{{ $membership->plan->plan_name }}</div>
                            </div>
                        </div>

                        <hr class="border-white opacity-50">

                        {{-- Dates --}}
                        <div class="row">
                            <div class="col-6">
                                <small class="opacity-75">Start Date</small>
                                <div class="fw-bold">
                                    {{ \Carbon\Carbon::parse($membership->start_date)->format('d M Y') }}
                                </div>
                            </div>
                            <div class="col-6">
                                <small class="opacity-75">Expiry Date</small>
                                <div class="fw-bold">
                                    {{ \Carbon\Carbon::parse($membership->end_date)->format('d M Y') }}
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Extra Info --}}
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <small class="text-muted">Member</small>
                                    <div class="fw-bold">{{ $membership->user->name }}</div>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted">Duration</small>
                                    <div class="fw-bold">
                                        {{ $membership->plan->duration_days }} days
                                    </div>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted">Price</small>
                                    <div class="fw-bold text-success">
                                        Rs. {{ number_format($membership->plan->price, 0) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

@endsection