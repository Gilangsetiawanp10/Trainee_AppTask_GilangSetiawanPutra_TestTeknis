@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="w-20 h-20 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-shield text-white text-2xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Portal Administrator</h2>
            <p class="text-gray-600">Khusus akses administrator</p>
        </div>

        <!-- Admin Login Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-orange-500">
            <div class="px-6 py-8">
                <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-envelope mr-2 text-gray-400"></i>
                            Email Administrator
                        </label>
                        <input id="email" type="email" 
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200 @error('email') border-red-500 ring-red-200 @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Masukkan email administrator">
                        
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
                            Kata Sandi Administrator
                        </label>
                        <input id="password" type="password" 
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200 @error('password') border-red-500 ring-red-200 @enderror"
                               name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi administrator">
                        
                        @error('password')
                            <div class="flex items-center mt-2 text-red-600 text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded" 
                                   type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="ml-2 block text-sm text-gray-700" for="remember">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <!-- Admin Login Button -->
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-200 transform hover:scale-105">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Masuk Sebagai Admin
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer Links -->
            <div class="px-6 py-4 bg-orange-50 border-t border-orange-200">
                <div class="text-center space-y-2">
                    <p class="text-sm text-orange-800 font-medium">
                        <i class="fas fa-info-circle mr-1"></i>
                        Area Akses Terbatas
                    </p>
                    <a href="{{ route('login') }}" 
                       class="text-sm text-orange-600 hover:text-orange-700 transition duration-200">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Kembali ke Login User
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection