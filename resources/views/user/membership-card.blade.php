{{--
|--------------------------------------------------------------------------
| User - Membership Card Page
|--------------------------------------------------------------------------
| Shows the user's digital membership card.
| User shows this code to gym owner for verification.
--}}

@extends('layouts.app')

@section('title', 'My Membership Card - GymPass Portal')

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

            <a href="{{ route('user.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('user.buy.membership') }}">
                <i class="bi bi-cart-plus"></i> Buy Membership
            </a>
            <a href="{{ route('user.membership') }}" class="active">
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

            <div class="row justify-content-center">
                <div class="col-md-6">

                    <h2 class="fw-bold mb-4">
                        <i class="bi bi-credit-card text-primary"></i>
                        My Membership Card
                    </h2>

                    {{-- DIGITAL MEMBERSHIP CARD --}}
                    <div class="membership-card mb-4">

                        {{-- Card Header --}}
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h4 class="mb-0">
                                    <i class="bi bi-trophy-fill text-warning"></i>
                                    GymPass Portal
                                </h4>
                                <small class="opacity-75">
                                    Digital Membership Card
                                </small>
                            </div>
                            {{-- Status Badge --}}
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

                        {{-- Membership Code - Big and Bold --}}
                        <div class="bg-white bg-opacity-25 rounded-3 p-3 mb-4 text-center">
                            <small class="opacity-75">Membership Code</small>
                            <h3 class="mb-0 fw-bold letter-spacing-2">
                                {{ $membership->membership_code }}
                            </h3>
                            <small class="opacity-75">
                                Show this code to gym owner
                            </small>
                        </div>

                        {{-- Area and Plan --}}
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="opacity-75">Area</small>
                                <div class="fw-bold fs-5">
                                    {{ $membership->area->name }}
                                </div>
                            </div>
                            <div class="col-6">
                                <small class="opacity-75">Plan</small>
                                <div class="fw-bold fs-5">
                                    {{ $membership->plan->plan_name }}
                                </div>
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
                    {{-- END MEMBERSHIP CARD --}}

                    {{-- Price Info --}}
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <small class="text-muted">Duration</small>
                                    <div class="fw-bold">
                                        {{ $membership->plan->duration_days }} days
                                    </div>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted">Price Paid</small>
                                    <div class="fw-bold text-success">
                                        Rs. {{ number_format($membership->plan->price, 0) }}
                                    </div>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted">Valid In</small>
                                    <div class="fw-bold text-primary">
                                        {{ $membership->area->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        {{-- END MAIN CONTENT --}}

    </div>
</div>

@endsection