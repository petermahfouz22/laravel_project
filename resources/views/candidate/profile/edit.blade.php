<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Profile</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>
                    <form method="POST" action="{{ route('candidate.profile.update') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                            @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                            @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                            @error('phone') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                            <textarea id="bio" name="bio" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>