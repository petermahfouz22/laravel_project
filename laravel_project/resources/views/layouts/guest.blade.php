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

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-50">
    <!-- Navigation -->
    @if (Route::has('login'))
        <nav class="fixed top-0 z-50 w-full px-6 md:px-12 py-4 bg-gray-900 bg-opacity-95 shadow-lg">
            <div class="container mx-auto flex justify-between items-center">
                <!-- Logo -->
                <a href="{{ route('welcome') }}">
                    <div class="text-2xl font-bold text-white tracking-tight">JobFinder</div>
                </a>

                <!-- Desktop Menu -->
                <ul class="hidden md:flex space-x-8">
                    <li><a href="{{ route('welcome') }}"
                            class="text-white font-medium hover:text-teal-300 transition-colors">Home</a></li>
                    <li><a href="{{ route('about') }}"
                            class="text-white font-medium hover:text-teal-300 transition-colors">About</a></li>
                    <li><a href="{{ route('job_search') }}"
                            class="text-white font-medium hover:text-teal-300 transition-colors">Discover Jobs</a></li>
                    <li><a href="{{ route('job_category') }}"
                            class="text-white font-medium hover:text-teal-300 transition-colors">Jobs by Industry</a></li>
                    <li><a href="{{ route('contact us') }}"
                            class="text-white font-medium hover:text-teal-300 transition-colors">Contact Us</a></li>
                </ul>

                <!-- Desktop Auth Links -->
                <div class="hidden md:flex space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="bg-teal-500 text-white px-6 py-2 rounded-full font-medium hover:bg-teal-600 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-teal-500 text-white px-6 py-2 rounded-full font-medium hover:bg-teal-600 transition-colors">Log
                            in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="border-2 border-teal-500 text-teal-500 px-6 py-2 rounded-full font-medium hover:bg-teal-500 hover:text-white transition-colors">Register</a>
                        @endif
                    @endauth
                </div>

                <!-- Mobile Menu Toggle -->
                <button id="menu-toggle" class="md:hidden text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu"class="hidden md:hidden flex flex-col items-center w-full bg-gray-900 text-white p-6 space-y-4">
                <a href="{{ route('welcome') }}" class="text-white font-medium hover:text-teal-300 transition-colors">Home</a>
                <a href="{{ route('about') }}" class="text-white font-medium hover:text-teal-300 transition-colors">About</a>
                <a href="{{ route('job_search') }}" class="text-white font-medium hover:text-teal-300 transition-colors">Discover
                    Jobs</a>
                <a href="{{ route('job_category') }}" class="text-white font-medium hover:text-teal-300 transition-colors">Jobs
                    by Industry</a>
                <a href="{{ route('contact us') }}" class="text-white font-medium hover:text-teal-300 transition-colors">Contact
                    Us</a>
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="bg-teal-500 text-white px-6 py-2 rounded-full font-medium hover:bg-teal-600 transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-teal-500 text-white px-6 py-2 rounded-full font-medium hover:bg-teal-600 transition-colors">Log
                        in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="border-2 border-teal-500 text-teal-500 px-6 py-2 rounded-full font-medium hover:bg-teal-500 hover:text-white transition-colors">Register</a>
                    @endif
                @endauth
            </div>
        </nav>
    @endif

    <!-- Main Content -->
    <div class="min-h-screen flex flex-col items-center pt-24 pb-12 bg-gradient-to-b from-gray-100 to-gray-200">
        <!-- Content Slot (replaced with yield) -->
        <div class="w-full sm:max-w-lg px-6 py-8 bg-white shadow-xl rounded-xl border border-gray-200">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6 text-center">
        <div>
            <p class="text-sm">© 2025 JobFinder. All rights reserved.</p>
            <ul class="flex justify-center space-x-6 mt-3">
                <li><a href="#" class="text-white hover:text-teal-300 transition-colors">About</a></li>
                <li><a href="#" class="text-white hover:text-teal-300 transition-colors">Privacy Policy</a></li>
                <li><a href="#" class="text-white hover:text-teal-300 transition-colors">Contact Us</a></li>
            </ul>
        </div>
    </footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
