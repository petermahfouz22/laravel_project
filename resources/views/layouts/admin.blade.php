<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JobFinder') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-50">
    <nav class="bg-gray-800 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo and Brand -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.dashboard') }}"><span class="text-xl font-bold">
                                Dashboard</span></a>
                    </div>

                    <!-- Main Navigation - Hidden on mobile -->
                    <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-3 py-2 rounded-md text-sm font-medium bg-gray-900">Dashboard</a>
                        <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Users</a>
                        <a href="{{ route('admin.jobs.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Jobs</a>
                    </div>
                </div>

                <!-- Right Navigation -->
                <div class="flex items-center">
                    <a href="{{ route('createAdmin') }}"
                    class="border-2 border-teal-500 text-teal-500 px-6 py-2 rounded-full font-medium hover:bg-teal-500 hover:text-white transition-colors">
                        <i class="fas fa-plus"></i>
                        <span>Add Admin</span>
                    </a>
                    <!-- Notifications -->
                    <button class="ml-4 relative p-1 rounded-full hover:bg-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"></span>
                    </button>

                    <!-- User Menu -->
                    <div class="ml-4 relative">
                        <div>
                            <button
                                class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <img class="h-8 w-8 rounded-full" src="https://via.placeholder.com/40"
                                    alt="User avatar">
                                <span class="ml-2 hidden md:block">Admin User</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <!-- Dropdown Menu - Hidden by default, add JS to toggle -->
                        <div
                            class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1" role="menu" aria-orientation="vertical">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem">Your Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem">Settings</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem">Sign out</a>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden ml-4">
                        <button class="p-2 rounded-md text-gray-400 hover:bg-gray-700 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu - Hidden by default, add JS to toggle -->
        <div class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium bg-gray-900">Dashboard</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Users</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Products</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Analytics</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Settings</a>
            </div>
            <div class="px-2 pt-2 pb-3 border-t border-gray-700">
                <div class="flex items-center px-3 py-2">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/40" alt="User avatar">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium">Admin User</div>
                        <div class="text-sm font-medium text-gray-400">admin@example.com</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Your
                        Profile</a>
                    <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Settings</a>
                    <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Sign out</a>
                </div>
            </div>
        </div>
    </nav>
    @yield('content')

    @yield('scripts')

</body>

</html>
