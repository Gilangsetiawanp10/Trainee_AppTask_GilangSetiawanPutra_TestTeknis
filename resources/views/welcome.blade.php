<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DateTime Picker CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

    <style>
        .status-dropdown {
            position: relative;
        }
        .status-options {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            min-width: 120px;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Trainee Task Manager
                </a>
                
                <div class="navbar-nav ms-auto">
                    @if(Auth::guard('admin')->check() || Auth::guard('web')->check())
                        <div class="dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" 
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(Auth::guard('admin')->check())
                                    {{ Auth::guard('admin')->user()->name }}
                                    <span class="badge bg-warning text-dark">Admin</span>
                                @else
                                    {{ Auth::guard('web')->user()->name }}
                                    <span class="badge bg-info">User</span>
                                @endif
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                @if(Auth::guard('admin')->check())
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                @else
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                @endif
                            </div>
                        </div>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    @endif
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('scripts')
</body>
</html>
