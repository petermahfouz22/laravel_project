<x-admin-layout title="User Details">
  <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
      <div class="flex items-center justify-between mb-4">
          <h2 class="text-2xl font-semibold">User Details</h2>
          <div class="flex space-x-2">
              <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                  <i class="fas fa-edit mr-1"></i> Edit
              </a>
              <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="button" onclick="confirmDelete({{ $user->id }})" class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg px-4 py-2 transition shadow-md">
                      <i class="fas fa-trash"></i> Delete
                  </button>
              </form>
          </div>
      </div>
      <div class="flex mb-6">
          <div class="w-1/3">
              @if($user->profile_image)
                  <img src="{{ asset("storage/{$user->profile_image}") }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover">
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
              @php
                  $candidate = $user->candidate ?? null;
              @endphp
              @if($candidate)
                  <div class="space-y-3">
                      <div>
                          <p class="text-gray-600 text-sm">Skills</p>
                          <p class="font-medium">{{ $candidate->skills ?? 'Not specified' }}</p>
                      </div>
                      <div>
                          <p class="text-gray-600 text-sm">Job Preferences</p>
                          <p class="font-medium">{{ $candidate->job_preferences ?? 'Not specified' }}</p>
                      </div>
                      <div>
                          <p class="text-gray-600 text-sm">Total Applications</p>
                          <p class="font-medium">{{ $user->applications()->count() }}</p>
                      </div>
                      <div>
                          <p class="text-gray-600 text-sm">Saved Jobs</p>
                          <p class="font-medium">{{ $user->savedJobs()->count() }}</p>
                      </div>
                  </div>
              @else
                  <p class="text-gray-500">No additional candidate information available.</p>
              @endif
          </div>
      @elseif($user->role == 'employer')
          <div class="mt-4 border-t pt-4">
              <h3 class="font-semibold text-lg mb-2">Employer Information</h3>
              @php
                  $company = $user->company ?? null;
              @endphp
              @if($company)
                  <div class="space-y-3">
                      <div>
                          <p class="text-gray-600 text-sm">Company Name</p>
                          <p class="font-medium">{{ $company->name }}</p>
                      </div>
                      <div>
                          <p class="text-gray-600 text-sm">Total Jobs Posted</p>
                          <p class="font-medium">{{ $user->postedJobs()->count() }}</p>
                      </div>
                      <div>
                          <p class="text-gray-600 text-sm">Active Jobs</p>
                          <p class="font-medium">{{ $user->postedJobs()->where('is_active', true)->count() }}</p>
                      </div>
                      <div>
                          <p class="text-gray-600 text-sm">Total Applications Received</p>
                          <p class="font-medium">{{ \App\Models\Application::whereIn('job_id', $user->postedJobs()->pluck('id'))->count() }}</p>
                      </div>
                  </div>
              @else
                  <p class="text-gray-500">No company information available.</p>
              @endif
          </div>
      @elseif($user->role == 'admin')
          <div class="mt-4 border-t pt-4">
              <h3 class="font-semibold text-lg mb-2">Admin Information</h3>
              <div class="space-y-3">
                  <div>
                      <p class="text-gray-600 text-sm">Admin Level</p>
                      <p class="font-medium capitalize">
                          {{ $user->admin_level ?? 'Not specified' }}
                      </p>
                  </div>
                  <div>
                      <p class="text-gray-600 text-sm">Total Users Managed</p>
                      <p class="font-medium">
                          {{ \App\Models\User::count() }}
                      </p>
                  </div>
                  <div>
                      <p class="text-gray-600 text-sm">Total Jobs Managed</p>
                      <p class="font-medium">
                          {{ \App\Models\Job::count() }}
                      </p>
                  </div>
                  <div>
                      <p class="text-gray-600 text-sm">Pending Job Approvals</p>
                      <p class="font-medium">
                          {{ \App\Models\Job::where('is_approved', false)->count() }}
                      </p>
                  </div>
              </div>
          </div>
      @endif
  </div>

  @push('scripts')
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
          function confirmDelete(userId) {
              Swal.fire({
                  title: "Are you sure?",
                  text: "You won't be able to revert this!",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#d33",
                  cancelButtonColor: "#3085d6",
                  confirmButtonText: "Yes, delete it!"
              }).then((result) => {
                  if (result.isConfirmed) {
                      document.getElementById(`delete-form-${userId}`).submit();
                  }
              });
          }
      </script>
  @endpush
</x-admin-layout>