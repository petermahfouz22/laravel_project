@extends('layouts.admin')

@section('content')
<div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
    <div class="flex justify-center">
        <h1 class="text-3xl font-semibold text-gray-800 tracking-wide mb-4">Edit User</h1>
    </div>
    <form method="POST" action="{{ route('editUser', $user->id) }}">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                class="block mt-1 w-full border border-gray-300 rounded-lg p-2">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                class="block mt-1 w-full border border-gray-300 rounded-lg p-2">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-6">
            <a href="{{ route('admin.users/index') }}" class="text-blue-600 hover:underline text-sm">Cancel</a>
            <button type="submit"
                class="ml-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
