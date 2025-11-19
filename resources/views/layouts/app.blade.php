<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DateTime Picker CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .status-dropdown {
            position: relative;
            display: inline-block;
        }
        .status-options {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        .status-options a {
            color: black;
            padding: 8px 12px;
            text-decoration: none;
            display: block;
        }
        .status-options a:hover {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div id="app">
        <nav class="bg-white shadow-lg border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex-shrink-0">
                        <a class="text-gray-800 text-xl font-bold hover:text-primary-600 transition duration-200" href="{{ url('/') }}">
                            <i class="fas fa-tasks mr-2 text-primary-500"></i>
                            Trainee Task
                        </a>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        @guest
                            @if (Route::has('login'))
                                <a class="text-gray-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200" 
                                   href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt mr-1"></i>
                                    Login
                                </a>
                            @endif
                            @if (Route::has('register'))
                                <a class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 shadow-sm" 
                                   href="{{ route('register') }}">
                                    <i class="fas fa-user-plus mr-1"></i>
                                    Register
                                </a>
                            @endif
                            <a class="text-gray-600 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200" 
                               href="{{ route('admin.login') }}">
                                <i class="fas fa-user-shield mr-1"></i>
                                Admin Login
                            </a>
                        @else
                            <div class="flex items-center space-x-4">
                                @auth
                                    <a href="{{ route('trainee-tasks.index') }}" 
                                       class="text-gray-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200">
                                        <i class="fas fa-list mr-1"></i>
                                        Tasks
                                    </a>
                                @endauth
                                
                                <div class="relative">
                                    <button class="flex items-center text-gray-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200" 
                                            onclick="toggleDropdown()">
                                        <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white text-sm font-semibold mr-2">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                        <span>{{ Auth::user()->name }}</span>
                                        @if(Auth::guard('admin')->check())
                                            <span class="ml-2 bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-semibold">Admin</span>
                                        @endif
                                        <i class="fas fa-chevron-down ml-2 text-xs"></i>
                                    </button>
                                    
                                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200">
                                        <div class="px-4 py-2 border-b border-gray-200">
                                            <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                                            <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                        </div>
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition duration-200" 
                                           href="{{ route('home') }}">
                                            <i class="fas fa-home mr-2"></i>
                                            Dashboard
                                        </a>
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition duration-200" 
                                           href="{{ route('trainee-tasks.index') }}">
                                            <i class="fas fa-tasks mr-2"></i>
                                            My Tasks
                                        </a>
                                        <hr class="my-2">
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition duration-200" 
                                           href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt mr-2"></i>
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-8">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const button = e.target.closest('button');
            if (!button || !button.onclick) {
                dropdown?.classList.add('hidden');
            }
        });
    </script>

    @yield('scripts')
</body>
</html>