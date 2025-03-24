<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Your Applications') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold">Your Job Applications</h3>
                    <p class="mt-2">Track your applications here.</p>

                    @if ($applications->isEmpty())
                        <p class="mt-4 text-gray-600">You haven’t applied to any jobs yet.</p>
                    @else
                        <ul class="mt-4 space-y-4">
                            @foreach ($applications as $application)
                                <li class="border-b pb-4">
                                    <h4 class="text-lg font-semibold">{{ $application->job->title }}</h4>
                                    <p class="text-gray-600">Applied on: {{ $application->created_at->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-500">Resume: {{ $application->resume ? basename($application->resume) : 'None' }}</p>
                                </li>
                            @endforeach
                        </ul>
                        {{ $applications->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>