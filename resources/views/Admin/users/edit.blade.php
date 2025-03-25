<x-admin-layout title="Edit User">
  <div class="container mx-auto mt-10">
      <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6">
          <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Edit User Profile</h2>
          
          <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
              @csrf
              @method('PUT')
              
              <div>
                  <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                  <input 
                      type="text" 
                      name="name" 
                      id="name" 
                      value="{{ old('name', $user->name) }}" 
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                      required
                  >
                  @error('name')
                      <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                  @enderror
              </div>

              <div>
                  <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                  <input 
                      type="email" 
                      name="email" 
                      id="email" 
                      value="{{ old('email', $user->email) }}" 
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                      required
                  >
                  @error('email')
                      <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                  @enderror
              </div>

              {{-- Role-specific fields will be inserted here --}}
              @if(auth()->user()->isAdmin())
                  <x-user-role-fields :user="$user" />
              @endif

              <div class="flex items-center justify-between">
                  <a 
                      href="{{ route('admin.users.index') }}" 
                      class="text-gray-600 hover:text-gray-900"
                  >
                      Cancel
                  </a>
                  <button 
                      type="submit" 
                      class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                  >
                      Update User
                  </button>
              </div>
          </form>
      </div>
  </div>
</x-admin-layout>