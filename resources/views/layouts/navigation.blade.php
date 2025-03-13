<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/">
                    <img class="h-8 w-auto" src="{{ asset('logo.png') }}" alt="JobBoard">
                </a>
            </div>

            <!-- Main Navigation -->
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                <a href="{{ route('jobs.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Jobs</a>
                <a href="#" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Companies</a>
            </div>

            <!-- Right Navigation -->
            <div class="flex items-center">
                @auth
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <!-- Role-Specific Links -->
                    @if(auth()->user()->role === 'employer')
                        <a href="{{ route('employer.dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Dashboard</a>
                    @elseif(auth()->user()->role === 'candidate')
                        <a href="{{ route('candidate.dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Profile</a>
                    @endif

                    <!-- User Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                                {{ Auth::user()->name }}
                                <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
                @else
                <div class="flex space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Register</a>
                </div>
                @endauth
            </div>
        </div>
    </div>
</nav>