<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPass Portal</title>

    {{-- Bootstrap CSS from CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Custom Styles --}}
    <style>
        /* Main navbar styling */
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #fff !important;
        }

        /* Sidebar styling for dashboard pages */
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
            padding-top: 20px;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 2px 10px;
        }

        .sidebar a:hover {
            background-color: #343a40;
            color: #fff;
        }

        .sidebar a.active {
            background-color: #0d6efd;
            color: #fff;
        }

        /* Main content area */
        .main-content {
            padding: 30px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        /* Card styling */
        .stat-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Membership card styling */
        .membership-card {
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            color: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

    {{-- TOP NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">

            {{-- Brand/Logo --}}
            <a class="navbar-brand" href="#">
                <i class="bi bi-trophy-fill text-warning"></i>
                GymPass Portal
            </a>

            {{-- Mobile toggle button --}}
            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Navbar links --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    {{-- Show these links only when logged in --}}
                    @auth
                        <li class="nav-item">
                            {{-- Show user's name in navbar --}}
                            <span class="nav-link text-light">
                                <i class="bi bi-person-circle"></i>
                                {{ Auth::user()->name }}
                                <span class="badge bg-warning text-dark ms-1">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </span>
                        </li>
                        <li class="nav-item">
                            {{-- Logout button --}}
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm ms-2">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    @endauth

                    {{-- Show these links only when NOT logged in --}}
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endguest

                </ul>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT AREA --}}
    {{-- @yield('content') is a placeholder.
         Each page will inject its own content here. --}}
    @yield('content')

    {{-- Bootstrap JavaScript from CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>