@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="w-20 h-20 bg-primary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user text-white text-2xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Hallo, Selamat Datang!</h2>
            <p class="text-gray-600">Masuk ke akun Anda</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-8">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-envelope mr-2 text-gray-400"></i>
                            Alamat Email
                        </label>
                        <input id="email" type="email" 
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 @error('email') border-red-500 ring-red-200 @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Masukkan email Anda">
                        
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
                            Kata Sandi
                        </label>
                        <input id="password" type="password" 
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 @error('password') border-red-500 ring-red-200 @enderror"
                               name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi Anda">
                        
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
                            <input class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" 
                                   type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="ml-2 block text-sm text-gray-700" for="remember">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200 transform hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Masuk
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer Links -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="space-y-3">
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Belum memiliki akun?</p>
                        <a href="{{ route('register') }}" 
                           class="font-medium text-primary-600 hover:text-primary-500 transition duration-200">
                            <i class="fas fa-user-plus mr-1"></i>
                            Buat akun baru
                        </a>
                    </div>
                    
                    <div class="text-center pt-2 border-t border-gray-200">
                        <a href="{{ route('admin.login') }}" 
                           class="text-sm text-gray-500 hover:text-gray-700 transition duration-200">
                            <i class="fas fa-user-shield mr-1"></i>
                            Login Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection