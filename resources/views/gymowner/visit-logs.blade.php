{{--
|--------------------------------------------------------------------------
| Gym Owner - Visit Logs Page
|--------------------------------------------------------------------------
| Shows all visits that happened at this gym owner's gym.
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
                <span class="badge bg-success">Gym Owner</span>
            </div>

            <a href="{{ route('gymowner.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('gymowner.verify') }}">
                <i class="bi bi-qr-code-scan"></i> Verify Membership
            </a>
            <a href="{{ route('gymowner.visit.logs') }}" class="active">
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
                    <i class="bi bi-journal-text text-success"></i>
                    Visit Logs
                </h2>
                @if($gym)
                    <small class="text-muted">
                        Visits at {{ $gym->gym_name }}
                    </small>
                @endif
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
                                <th>Plan</th>
                                <th>Visit Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($visitLogs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>
                                        <i class="bi bi-person-circle text-primary"></i>
                                        {{ $log->membership->user->name }}
                                    </td>
                                    <td>
                                        <span class="badge bg-dark">
                                            {{ $log->membership->membership_code }}
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
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-1"></i>
                                        <br>No visits recorded yet.
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