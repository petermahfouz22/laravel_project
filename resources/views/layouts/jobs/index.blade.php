@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Bar -->
        <div class="mb-8">
            <form class="flex gap-4">
                <input type="text" placeholder="Job title or keywords" 
                       class="flex-1 rounded-lg border-gray-300 shadow-sm">
                <input type="text" placeholder="Location" 
                       class="flex-1 rounded-lg border-gray-300 shadow-sm">
                <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                    Search
                </button>
            </form>
        </div>

        <!-- Job Listings -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($jobs as $job)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <img src="{{ $job->company->logo }}" alt="Company Logo" 
                         class="h-12 w-12 rounded-full object-cover">
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-800">{{ $job->title }}</h3>
                        <p class="text-gray-600">{{ $job->company->name }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-gray-600"><i class="fas fa-map-marker-alt mr-2"></i>{{ $job->location }}</p>
                    <p class="text-gray-600"><i class="fas fa-clock mr-2"></i>{{ $job->created_at->diffForHumans() }}</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">
                            {{ $job->type }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('jobs.show', $job) }}" 
                   class="mt-4 inline-block w-full text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                    View Job
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection