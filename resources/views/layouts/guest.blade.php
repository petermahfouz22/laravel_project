<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
<header
        class="bg-[linear-gradient(rgba(0,0,50,0.7),rgba(0,0,50,0.7)),url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f')] bg-cover bg-center h-screen flex flex-col justify-center items-center text-white text-center relative">
        @if (Route::has('login'))
            <nav class="absolute top-0 w-full px-6 md:px-12 py-5 bg-gray-900 bg-opacity-80">
                <div class="container mx-auto flex justify-between items-center">
                    <div class="text-2xl font-bold">JobFinder</div>
                    <ul class="hidden md:flex space-x-6">
                        <li><a href="{{ route('welcome') }}" class="text-white font-medium hover:underline">Home</a></li>
                        <li><a href="#" class="text-white font-medium hover:underline">About</a></li>
                        <li><a href="{{ route('job_search') }}" class="text-white font-medium hover:underline">Discover Jobs</a></li>
                        <li><a href="#" class="text-white font-medium hover:underline">Jobs by Industry</a></li>
                        <li><a href="#" class="text-white font-medium hover:underline">Contact Us</a></li>
                    </ul>

                    <div class="hidden md:flex space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-teal-500 text-white px-6 py-2 rounded-full font-medium hover:bg-teal-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-teal-500 text-white px-6 py-2 rounded-full font-medium hover:bg-teal-600">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="border-2 border-teal-500 text-teal-500 px-6 py-2 rounded-full font-medium hover:bg-teal-500 hover:text-white">Register</a>
                            @endif
                        @endauth
                    </div>

                    <button id="menu-toggle" class="md:hidden text-white focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <div id="mobile-menu"class="hidden md:hidden flex flex-col items-center w-full bg-gray-900 text-white p-5 space-y-4">
                    <a href="#" class="hover:underline">Home</a>
                    <a href="#" class="hover:underline">About</a>
                    <a href="{{ route('job_search') }}" class="hover:underline">Discover Jobs</a>
                    <a href="#" class="hover:underline">Jobs by Industry</a>
                    <a href="#" class="hover:underline">Contact Us</a>
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="bg-teal-500 text-white px-6 py-2 rounded-full font-medium hover:bg-teal-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-teal-500 text-white px-6 py-2 rounded-full font-medium hover:bg-teal-600">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="border-2 border-teal-500 text-teal-500 px-6 py-2 rounded-full font-medium hover:bg-teal-500 hover:text-white">Register</a>
                        @endif
                    @endauth
                </div>
            </nav>
        @endif
        <div class="hero-content px-4 md:px-0 max-w-4xl">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-5">Find Your Dream Job</h1>
            <p class="text-base sm:text-lg md:text-xl font-light mb-8">Connecting skilled professionals with leading
                companies</p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <button
                    class="bg-teal-500 text-white px-6 py-3 rounded-full font-medium hover:bg-teal-600 w-full sm:w-auto">Search
                    Jobs</button>
                <button
                    class="border-2 border-teal-500 text-teal-500 px-6 py-3 rounded-full font-medium hover:bg-teal-500 hover:text-white w-full sm:w-auto">Post
                    a Job</button>
            </div>
        </div>
    </header>
    @yield('content')
</body>
</html>