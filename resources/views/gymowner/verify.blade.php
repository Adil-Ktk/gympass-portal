{{--
|--------------------------------------------------------------------------
| Gym Owner - Verify Membership Page
|--------------------------------------------------------------------------
| Gym owner enters membership code here.
| System checks if code is valid and logs the visit.
--}}

@extends('layouts.app')

@section('title', 'Verify Membership - GymPass Portal')

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

            <a href="{{ route('gymowner.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('gymowner.verify') }}" class="active">
                <i class="bi bi-qr-code-scan"></i> Verify Membership
            </a>
            <a href="{{ route('gymowner.visit.logs') }}">
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

            <div class="row justify-content-center mt-3">
                <div class="col-md-6">

                    <h2 class="fw-bold mb-4">
                        <i class="bi bi-qr-code-scan text-success"></i>
                        Verify Membership
                    </h2>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle-fill fs-5"></i>
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Error Message --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-x-circle-fill fs-5"></i>
                            <strong>{{ session('error') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Verification Form --}}
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-search"></i>
                                Enter Membership Code
                            </h5>
                        </div>
                        <div class="card-body p-4">

                            <form action="{{ route('gymowner.verify.post') }}" method="POST">
                                @csrf

                                {{-- Membership Code Field --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Membership Code
                                    </label>
                                    <input
                                        type="text"
                                        name="membership_code"
                                        class="form-control form-control-lg"
                                        placeholder="e.g. GYM-AB12CD34"
                                        required
                                        autofocus>
                                    <small class="text-muted">
                                        Ask the member to show their membership code.
                                    </small>
                                </div>

                                {{-- Submit Button --}}
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="bi bi-check-circle"></i>
                                        Verify & Log Visit
                                    </button>
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