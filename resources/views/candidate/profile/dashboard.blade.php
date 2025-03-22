@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">Welcome, {{ Auth::user()->name }}</h1>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Applications</h2>
            <p class="text-2xl">{{ $applicationsCount }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Saved Jobs</h2>
            <p class="text-2xl">{{ $savedJobsCount }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Notifications</h2>
            <p class="text-2xl">{{ $notificationsCount }}</p>
        </div>
    </div>

    <!-- Recommended Jobs -->
    <h2 class="text-2xl font-semibold mb-4">Recommended Jobs</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($recommendedJobs as $job)
            @include('components.candidate.job-card', ['job' => $job])
        @endforeach
    </div>
</div>
@endsection