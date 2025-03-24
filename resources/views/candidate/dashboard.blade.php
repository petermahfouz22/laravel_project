<!-- resources/views/candidate/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Candidate Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}!</h3>
                    <p class="mt-2">Your hub for finding and managing job opportunities.</p>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Profile Card -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-lg font-semibold">Your Profile</h4>
                    <p class="mt-2 text-gray-600">Update your personal info, skills, and resume.</p>
                    <a href="{{ route('candidate.profile.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">Go to Profile</a>
                </div>

                <!-- Jobs Card -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-lg font-semibold">Browse Jobs</h4>
                    <p class="mt-2 text-gray-600">Explore the latest job listings.</p>
                    <a href="{{ route('candidate.jobs.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">Find Jobs</a>
                </div>

                <!-- Applications Card -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-lg font-semibold">Your Applications</h4>
                    <p class="mt-2 text-gray-600">Track your job applications.</p>
                    <a href="{{ route('candidate.applications.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">View Applications</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>