{{-- resources/views/admin/users/editUser.blade.php --}}
<x-admin-layout title="Edit User">
  <div class="container mx-auto mt-10">
      <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8">
          <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Edit User Profile</h2>
          
          <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
              @csrf
              @method('PUT')
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
              </div>

              <div>
                  <label for="role" class="block text-sm font-medium text-gray-700">User Role</label>
                  <select 
                      name="role" 
                      id="role" 
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  >
                      <option value="candidate" {{ $user->role == 'candidate' ? 'selected' : '' }}>Candidate</option>
                      <option value="employer" {{ $user->role == 'employer' ? 'selected' : '' }}>Employer</option>
                      <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                  </select>
                  @error('role')
                      <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                  @enderror
              </div>

              {{-- Role-specific additional fields --}}
              @switch($user->role)
                  @case('admin')
                      <div>
                          <label for="admin_level" class="block text-sm font-medium text-gray-700">Admin Level</label>
                          <select 
                              name="admin_level" 
                              id="admin_level" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                          >
                              <option value="super_admin" {{ old('admin_level', $user->admin_level ?? '') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                              <option value="content_admin" {{ old('admin_level', $user->admin_level ?? '') == 'content_admin' ? 'selected' : '' }}>Content Admin</option>
                              <option value="user_admin" {{ old('admin_level', $user->admin_level ?? '') == 'user_admin' ? 'selected' : '' }}>User Admin</option>
                          </select>
                          @error('admin_level')
                              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                          @enderror
                      </div>
                      @break

                  @case('employer')
                      <div>
                          <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                          <input 
                              type="text" 
                              name="company_name" 
                              id="company_name" 
                              value="{{ old('company_name', $user->company->name ?? '') }}" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                          >
                          @error('company_name')
                              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                          @enderror
                      </div>
                      @break

                  @case('candidate')
                      <div class="space-y-4">
                          <div>
                              <label for="skills" class="block text-sm font-medium text-gray-700">Skills</label>
                              <input 
                                  type="text" 
                                  name="skills" 
                                  id="skills" 
                                  value="{{ old('skills', $user->candidate->skills ?? '') }}" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  placeholder="Enter skills separated by commas"
                              >
                              @error('skills')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <label for="job_preferences" class="block text-sm font-medium text-gray-700">Job Preferences</label>
                              <textarea 
                                  name="job_preferences" 
                                  id="job_preferences" 
                                  rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  placeholder="Describe your job preferences"
                              >{{ old('job_preferences', $user->candidate->job_preferences ?? '') }}</textarea>
                              @error('job_preferences')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>
                      </div>
                      @break
              @endswitch

              <div class="flex items-center justify-between mt-6">
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