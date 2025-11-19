@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-plus text-white text-2xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h2>
            <p class="text-gray-600">Join us and start managing your tasks</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name Field -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-user mr-2 text-gray-400"></i>
                            Full Name
                        </label>
                        <input id="name" type="text" 
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 @error('name') border-red-500 ring-red-200 @enderror"
                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your full name">
                        
                        @error('name')
                            <div class="flex items-center mt-2 text-red-600 text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-envelope mr-2 text-gray-400"></i>
                            Email Address
                        </label>
                        <input id="email" type="email" 
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 @error('email') border-red-500 ring-red-200 @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email">
                        
                        @error('email')
                            <div class="flex items-center mt-2 text-red-600 text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-lock mr-2 text-gray-400"></i>
                            Password
                        </label>
                        <input id="password" type="password" 
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 @error('password') border-red-500 ring-red-200 @enderror"
                               name="password" required autocomplete="new-password" placeholder="Create a password">
                        
                        @error('password')
                            <div class="flex items-center mt-2 text-red-600 text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="space-y-2">
                        <label for="password-confirm" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-lock mr-2 text-gray-400"></i>
                            Confirm Password
                        </label>
                        <input id="password-confirm" type="password" 
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                               name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                    </div>

                    <!-- Register Button -->
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200 transform hover:scale-105">
                            <i class="fas fa-user-plus mr-2"></i>
                            Create Account
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer Links -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="text-center">
                    <p class="text-sm text-gray-600">Already have an account?</p>
                    <a href="{{ route('login') }}" 
                       class="font-medium text-green-600 hover:text-green-500 transition duration-200">
                        <i class="fas fa-sign-in-alt mr-1"></i>
                        Sign in here
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection