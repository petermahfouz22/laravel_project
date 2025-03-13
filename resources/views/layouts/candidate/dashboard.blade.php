@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Applications -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Your Applications</h2>
                    <div class="space-y-4">
                        @foreach($applications as $application)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <h3 class="font-medium">{{ $application->job->title }}</h3>
                                <span class="text-sm 
                                    {{ $application->status === 'accepted' ? 'text-green-600' : 
                                       ($application->status === 'rejected' ? 'text-red-600' : 'text-gray-600') }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </div>
                            <p class="text-gray-600 mt-2">{{ $application->job->company->name }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Profile Summary -->
            <div class="bg-white rounded-lg shadow-md p-6 h-fit">
                <h2 class="text-xl font-semibold mb-4">Your Profile</h2>
                <div class="space-y-2">
                    <p class="text-gray-600">Completed Profile: 65%</p>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-indigo-600 h-2 rounded-full" style="width: 65%"></div>
                    </div>
                    <a href="#" class="inline-block mt-4 text-indigo-600 hover:text-indigo-700">Complete Profile →</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection