@extends('layouts.admin')

@section('content')
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-8 mt-12">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-6">Edit User</h1>
        </div>
        <form method="POST" action="{{ route('updateUser', $user->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                    required>
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                    required>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" 
                    class="w-full bg-gray-900 text-white py-2 px-4 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Update
                </button>
            </div>
        </form>
    </div>
@endsection