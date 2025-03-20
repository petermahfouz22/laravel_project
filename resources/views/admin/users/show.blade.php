@extends('layouts.admin')

@section('content')
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-semibold">User Details</h2>
            <div class="flex space-x-2">
                <a href="{{ route('editUser', $user->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <form action="{{ route('deleteUser', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        
        <div class="flex mb-6">
            <div class="w-1/3">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover">
                @else
                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center">
                        <span class="text-3xl text-gray-500">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                @endif
            </div>
            <div class="w-2/3">
                <div class="mb-3">
                    <p class="text-gray-600 text-sm">Name</p>
                    <p class="font-medium">{{ $user->name }}</p>
                </div>
                <div class="mb-3">
                    <p class="text-gray-600 text-sm">Email</p>
                    <p class="font-medium">{{ $user->email }}</p>
                </div>
                <div class="mb-3">
                    <p class="text-gray-600 text-sm">Role</p>
                    <p class="font-medium capitalize">{{ $user->role }}</p>
                </div>
                <div class="mb-3">
                    <p class="text-gray-600 text-sm">Created</p>
                    <p class="font-medium">{{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        @if($user->role == 'candidate')
            <div class="mt-4 border-t pt-4">
                <h3 class="font-semibold text-lg mb-2">Candidate Information</h3>
                <!-- Add candidate specific fields here -->
            </div>
        @elseif($user->role == 'employer')
            <div class="mt-4 border-t pt-4">
                <h3 class="font-semibold text-lg mb-2">Employer Information</h3>
                <!-- Add employer specific fields here -->
            </div>
        @elseif($user->role == 'admin')
            <div class="mt-4 border-t pt-4">
                <h3 class="font-semibold text-lg mb-2">Admin Information</h3>
                <!-- Add admin specific fields here -->
            </div>
        @endif
    </div>
@endsection