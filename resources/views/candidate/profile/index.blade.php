@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">Your Profile</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center mb-6">
            <img src="{{ $profile->profile_image ?? 'default-avatar.png' }}" alt="Profile Image" class="w-24 h-24 rounded-full mr-4">
            <div>
                <h2 class="text-2xl font-semibold">{{ Auth::user()->name }}</h2>
                <p class="text-gray-600">{{ $profile->location ?? 'Not specified' }}</p>
            </div>
        </div>

        <nav class="flex space-x-4 mb-6">
            <a href="{{ route('candidate.profile.personal') }}" class="text-blue-600 hover:underline">Personal Info</a>
            <a href="{{ route('candidate.profile.resume') }}" class="text-blue-600 hover:underline">Resume</a>
            <a href="{{ route('candidate.profile.skills') }}" class="text-blue-600 hover:underline">Skills</a>
            <a href="{{ route('candidate.profile.portfolio') }}" class="text-blue-600 hover:underline">Portfolio</a>
        </nav>

        <div>
            @yield('profile-content')
        </div>
    </div>
</div>
@endsection