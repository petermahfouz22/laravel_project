<x-admin-layout title="Create New Admin">
  <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-8 mt-12">
      <div class="text-center">
          <h1 class="text-4xl font-bold text-gray-800 mb-6">Create New Admin</h1>
      </div>
      @if ($errors->any())
          <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
              <p class="font-bold">Please fix the following errors:</p>
              <ul class="list-disc ml-5">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf
          <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
              <input type="text" id="name" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
          </div>
          <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
              <input type="email" id="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
          </div>
          <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
          </div>
          <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
              <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
          </div>
          <div>
              <label for="profile_image" class="block text-sm font-medium text-gray-700">Profile Image (Optional)</label>
              <input type="file" id="profile_image" name="profile_image" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
              <p class="text-gray-500 text-xs mt-1">Max file size: 2MB. Accepted formats: JPG, PNG, GIF.</p>
          </div>
          <div class="text-center">
              <button type="submit" class="w-full bg-gray-900 text-white py-2 px-4 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                  Create Admin
              </button>
          </div>
      </form>
  </div>
</x-admin-layout>