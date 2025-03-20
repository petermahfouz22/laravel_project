@extends('layouts.admin')

@section('content')
<div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
    <div class="flex justify-center">
        <h1 class="text-3xl font-semibold text-gray-800 tracking-wide mb-4">Add Admin</h1>
    </div>
    <form method="POST" action="{{ route('addAdmin') }}">
        @csrf
        
        <!-- Name -->
        <div>
            <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
            <input id="name" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
            <input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
            <input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="password" name="password" required autocomplete="new-password" />
            @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password</label>
            <input id="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
            @error('password_confirmation') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Add
            </button>
        </div>
    </form>
</div>
@endsection
