@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Welcome Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome to Dashboard</h1>
            <p class="text-gray-600">Manage your tasks and track your progress</p>
        </div>

        <!-- Main Dashboard Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-8 text-white">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">Hello, {{ Auth::user()->name }}!</h2>
                        @if(Auth::guard('admin')->check())
                            <p class="text-primary-100">
                                <i class="fas fa-crown mr-1"></i>
                                Administrator Access
                            </p>
                        @else
                            <p class="text-primary-100">
                                <i class="fas fa-user mr-1"></i>
                                Trainee Account
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-6">
                @if (session('status'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span class="text-green-800 font-medium">{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Quick Actions -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-bolt text-primary-500 mr-2"></i>
                            Quick Actions
                        </h3>
                        
                        <a href="{{ route('trainee-tasks.index') }}" 
                           class="block w-full bg-primary-50 hover:bg-primary-100 border border-primary-200 rounded-lg p-4 transition duration-200 group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-primary-500 rounded-lg flex items-center justify-center mr-4 group-hover:bg-primary-600 transition duration-200">
                                    <i class="fas fa-list text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">View All Tasks</h4>
                                    <p class="text-sm text-gray-600">Manage and track your tasks</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
                            </div>
                        </a>

                        @if(Auth::guard('admin')->check())
                        <a href="{{ route('trainee-tasks.create') }}" 
                           class="block w-full bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg p-4 transition duration-200 group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-600 transition duration-200">
                                    <i class="fas fa-plus text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Create New Task</h4>
                                    <p class="text-sm text-gray-600">Assign tasks to trainees</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
                            </div>
                        </a>
                        @else
                        <a href="{{ route('trainee-tasks.create') }}" 
                           class="block w-full bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg p-4 transition duration-200 group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-600 transition duration-200">
                                    <i class="fas fa-plus text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Create New Task</h4>
                                    <p class="text-sm text-gray-600">Add your personal tasks</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
                            </div>
                        </a>
                        @endif
                    </div>

                    <!-- Account Info -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-user-circle text-primary-500 mr-2"></i>
                            Account Information
                        </h3>
                        
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Name:</span>
                                <span class="font-medium text-gray-800">{{ Auth::user()->name }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium text-gray-800">{{ Auth::user()->email }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Role:</span>
                                @if(Auth::guard('admin')->check())
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        <i class="fas fa-crown mr-1"></i>
                                        Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-user mr-1"></i>
                                        Trainee
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Member Since:</span>
                                <span class="font-medium text-gray-800">{{ Auth::user()->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity or Stats could go here -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="text-center">
                        <p class="text-gray-500 text-sm">
                            <i class="fas fa-info-circle mr-1"></i>
                            You are successfully logged in to the system
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection