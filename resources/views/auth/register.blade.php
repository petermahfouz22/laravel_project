@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo and Header -->
        <div>
            <img class="mx-auto h-20 w-auto" src="{{ asset('images/logo.png') }}" alt="JobBoard">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Create Your Account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Start your journey with us
            </p>
        </div>

        <!-- Form -->
        <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="rounded-lg shadow-sm space-y-4">
                <!-- Name -->
                <div>
                    <label for="name" class="sr-only">Full Name</label>
                    <input id="name" name="name" type="text" autocomplete="name" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300
                           placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500
                           focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Full Name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

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
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300
                           placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500
                           focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="sr-only">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" 
                           autocomplete="new-password" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300
                           placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500
                           focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Confirm Password">
                </div>

                <!-- Role Selection -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Register as:
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative">
                            <input class="peer hidden" id="employer" type="radio" name="role" value="employer">
                            <label for="employer" 
                                   class="block cursor-pointer text-center py-2 px-4 border border-gray-300 
                                   rounded-lg hover:border-indigo-500 peer-checked:border-indigo-600 
                                   peer-checked:bg-indigo-50 transition-colors">
                                Employer
                            </label>
                        </div>
                        <div class="relative">
                            <input class="peer hidden" id="candidate" type="radio" name="role" value="candidate" checked>
                            <label for="candidate" 
                                   class="block cursor-pointer text-center py-2 px-4 border border-gray-300 
                                   rounded-lg hover:border-indigo-500 peer-checked:border-indigo-600 
                                   peer-checked:bg-indigo-50 transition-colors">
                                Candidate
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"