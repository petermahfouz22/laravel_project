@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-4">{{ $job->title }}</h1>
        <p class="text-gray-600">{{ $job->company->name }} - {{ $job->location }}</p>
        <p class="text-sm text-gray-500 mt-2">{{ $job->work_type }} | ${{ $job->salary_min }} - ${{ $job->salary_max }}</p>

        <div class="mt-6">
            <h2 class="text-xl font-semibold">Description</h2>
            <p class="mt-2">{{ $job->description }}</p>
        </div>
        <div class="mt-6">
            <h2 class="text-xl font-semibold">Responsibilities</h2>
            <p class="mt-2">{{ $job->responsibilities }}</p>
        </div>
        <div class="mt-6">
            <h2 class="text-xl font-semibold">Requirements</h2>
            <p class="mt-2">{{ $job->requirements }}</p>
        </div>
        <div class="mt-6">
            <h2 class="text-xl font-semibold">Technologies</h2>
            @foreach ($job->technologies as $technology)
                <span class="inline-block bg-gray-200 text-gray-700 px-3 py-1 rounded-full mr-2 mb-2">{{ $technology->name }}</span>
            @endforeach
        </div>

        <div class="mt-6">
            <a href="{{ route('candidate.applications.create', ['job' => $job->id]) }}" class="bg-blue-600 text-white px-6 py-3 rounded-md">Apply Now</a>
            <a href="{{ route('candidate.jobs.save', ['job' => $job->id]) }}" class="ml-4 text-blue-600 hover:underline">Save Job</a>
        </div>
    </div>
</div>
@endsection