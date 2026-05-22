{{--
|--------------------------------------------------------------------------
| User - Buy Membership Page
|--------------------------------------------------------------------------
| User selects area and plan to purchase membership.
| No real payment - membership activates automatically.
--}}

@extends('layouts.app')

@section('title', 'Buy Membership - GymPass Portal')

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
            <a href="{{ route('user.buy.membership') }}" class="active">
                <i class="bi bi-cart-plus"></i> Buy Membership
            </a>
            <a href="{{ route('user.membership') }}">
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
                <div class="col-md-7">

                    <h2 class="fw-bold mb-4">
                        <i class="bi bi-cart-plus text-primary"></i>
                        Buy Membership
                    </h2>

                    {{-- Error Message --}}
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div><i class="bi bi-exclamation-circle"></i> {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Buy Membership Form --}}
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-card-checklist"></i>
                                Select Your Plan
                            </h5>
                        </div>
                        <div class="card-body p-4">

                            <form action="{{ route('user.membership.store') }}" method="POST">
                                @csrf

                                {{-- Area Selection --}}
                                <div class="mb-4">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-geo-alt"></i>
                                        Select Area
                                    </label>
                                    <select name="area_id"
                                            class="form-select form-select-lg"
                                            required>
                                        <option value="">-- Select Your Area --</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}"
                                                {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                                {{ $area->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">
                                        Your membership will work in all gyms
                                        within this area.
                                    </small>
                                </div>

                                {{-- Plan Selection --}}
                                <div class="mb-4">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-card-list"></i>
                                        Select Plan
                                    </label>

                                    {{-- Show plans as clickable cards --}}
                                    <div class="row g-3">
                                        @foreach($plans as $plan)
                                            <div class="col-md-6">
                                                <div class="card border-2 plan-card"
                                                     style="cursor:pointer">
                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input"
                                                                type="radio"
                                                                name="plan_id"
                                                                id="plan{{ $plan->id }}"
                                                                value="{{ $plan->id }}"
                                                                {{ old('plan_id') == $plan->id ? 'checked' : '' }}
                                                                required>
                                                            <label class="form-check-label w-100"
                                                                   for="plan{{ $plan->id }}">
                                                                <strong>{{ $plan->plan_name }}</strong>
                                                                <div class="text-muted small">
                                                                    {{ $plan->duration_days }} days
                                                                </div>
                                                                <div class="text-success fw-bold">
                                                                    Rs. {{ number_format($plan->price, 0) }}
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Submit Button --}}
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-check-circle"></i>
                                        Activate Membership
                                    </button>
                                </div>

                                <div class="text-center mt-2">
                                    <small class="text-muted">
                                        Membership activates immediately after clicking above.
                                    </small>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
        {{-- END MAIN CONTENT --}}

    </div>
</div>

@endsection