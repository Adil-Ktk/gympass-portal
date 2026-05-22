{{--
|--------------------------------------------------------------------------
| User Dashboard Page
|--------------------------------------------------------------------------
| Shows user their membership status.
| If no membership, shows button to buy one.
--}}

@extends('layouts.app')

@section('title', 'Dashboard - GymPass Portal')

@section('content')

<div class="container-fluid">
    <div class="row">

        {{-- SIDEBAR --}}
        <div class="col-md-2 sidebar p-0">
            <div class="p-3 text-white text-center border-bottom border-secondary">
                <i class="bi bi-person-circle fs-1"></i>
                <div class="small mt-1">{{ Auth::user()->name }}</div>
                <span class="badge bg-primary">Member</span>
            </div>

            <a href="{{ route('user.dashboard') }}"
               class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('user.buy.membership') }}"
               class="{{ request()->routeIs('user.buy*') ? 'active' : '' }}">
                <i class="bi bi-cart-plus"></i> Buy Membership
            </a>
            <a href="{{ route('user.membership') }}"
               class="{{ request()->routeIs('user.membership') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i> My Membership
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
                    <i class="bi bi-speedometer2 text-primary"></i>
                    My Dashboard
                </h2>
                <small class="text-muted">
                    Welcome, {{ Auth::user()->name }}!
                </small>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Error Message --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Check if user has membership --}}
            @if($membership)

                {{-- MEMBERSHIP CARD --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="membership-card">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h4 class="mb-0">
                                        <i class="bi bi-trophy-fill text-warning"></i>
                                        GymPass Portal
                                    </h4>
                                    <small>Digital Membership Card</small>
                                </div>
                                {{-- Status Badge --}}
                                @if($membership->status === 'active')
                                    <span class="badge bg-success fs-6">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6">
                                        Expired
                                    </span>
                                @endif
                            </div>

                            {{-- Member Name --}}
                            <h3 class="mb-3">{{ Auth::user()->name }}</h3>

                            {{-- Membership Code --}}
                            <div class="bg-white bg-opacity-25 rounded p-2 mb-3">
                                <small>Membership Code</small>
                                <h5 class="mb-0 fw-bold">
                                    {{ $membership->membership_code }}
                                </h5>
                            </div>

                            {{-- Details Row --}}
                            <div class="row">
                                <div class="col-6">
                                    <small>Area</small>
                                    <div class="fw-bold">{{ $membership->area->name }}</div>
                                </div>
                                <div class="col-6">
                                    <small>Plan</small>
                                    <div class="fw-bold">{{ $membership->plan->plan_name }}</div>
                                </div>
                            </div>

                            <hr class="border-white opacity-50">

                            {{-- Dates Row --}}
                            <div class="row">
                                <div class="col-6">
                                    <small>Start Date</small>
                                    <div class="fw-bold">{{ $membership->start_date }}</div>
                                </div>
                                <div class="col-6">
                                    <small>Expiry Date</small>
                                    <div class="fw-bold">{{ $membership->end_date }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- View Full Card Button --}}
                        <div class="mt-3">
                            <a href="{{ route('user.membership') }}"
                               class="btn btn-primary">
                                <i class="bi bi-credit-card"></i>
                                View Full Membership Card
                            </a>
                        </div>
                    </div>
                </div>

            @else
                {{-- NO MEMBERSHIP MESSAGE --}}
                <div class="card shadow-sm border-0 text-center p-5">
                    <div class="mb-4">
                        <i class="bi bi-credit-card-2-front fs-1 text-muted"></i>
                    </div>
                    <h4>You don't have a membership yet!</h4>
                    <p class="text-muted">
                        Purchase a membership to access gyms in your area.
                    </p>
                    <div>
                        <a href="{{ route('user.buy.membership') }}"
                           class="btn btn-primary btn-lg">
                            <i class="bi bi-cart-plus"></i>
                            Buy Membership Now
                        </a>
                    </div>
                </div>
            @endif

        </div>
        {{-- END MAIN CONTENT --}}

    </div>
</div>

@endsection