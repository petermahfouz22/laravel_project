<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Profile</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Profile Overview</h1>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    @if ($user->phone)<p><strong>Phone:</strong> {{ $user->phone }}</p>@endif
                    @if ($user->bio)<p><strong>Bio:</strong> {{ $user->bio }}</p>@endif
                    <p><strong>Resumes:</strong> {{ $user->resumes->count() }}</p>

                    <div class="mt-4">
                        <a href="{{ route('candidate.profile.edit') }}" class="text-blue-600 hover:underline">Edit Profile</a> |
                        <a href="{{ route('candidate.profile.resumes') }}" class="text-blue-600 hover:underline">Manage Resumes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>