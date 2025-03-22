@extends('candidate.profile.index')
@section('profile-content')
<h2 class="text-xl font-semibold mb-4">Personal Information</h2>
<form method="POST" action="{{ route('candidate.profile.update.user') }}">
    @csrf @method('PUT')
    <div class="grid grid-cols-1 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" value="{{ auth()->user()->name }}" class="mt-1 block w-full border-gray-300 rounded-md">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}" class="mt-1 block w-full border-gray-300 rounded-md">
        </div>
    </div>
    <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Save User Details</button>
</form>
<form method="POST" action="{{ route('candidate.profile.update') }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="grid grid-cols-1 gap-4 mt-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Bio</label>
            <textarea name="bio" class="mt-1 block w-full border-gray-300 rounded-md">{{ $profile->bio }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Location</label>
            <input type="text" name="location" value="{{ $profile->location }}" class="mt-1 block w-full border-gray-300 rounded-md">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="text" name="phone" value="{{ $profile->phone }}" class="mt-1 block w-full border-gray-300 rounded-md">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Profile Image</label>
            <input type="file" name="profile_image" class="mt-1 block w-full">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">LinkedIn URL</label>
            <input type="url" name="linkedin_url" value="{{ $profile->linkedin_url }}" class="mt-1 block w-full border-gray-300 rounded-md">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Website</label>
            <input type="url" name="website" value="{{ $profile->website }}" class="mt-1 block w-full border-gray-300 rounded-md">
        </div>
    </div>
    <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Save Profile</button>
</form>
@endsection