@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo and Header -->
        <div>
            <img class="mx-auto h-20 w-auto" src="{{ asset('images/logo.png') }}" alt="JobBoard">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Welcome Back to JobBoard
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Connect with your next opportunity
            </p>
        </div>

        <!-- Form -->
        <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="rounded-lg shadow-sm space-y-4">
                <!-- Email -->
                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300
                           placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500
                           focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Email address">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300
                           placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500
                           focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox"
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                        Remember me
                    </label>
                </div>
                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Forgot your password?
                    </a>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm
                    font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                    focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                Sign in to your account
            </button>

            <!-- Registration Link -->
            <div class="text-center text-sm">
                <span class="text-gray-600">Not a member? </span>
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Create account
                </a>
            </div>
        </form>
    </div>
</div>
@endsection