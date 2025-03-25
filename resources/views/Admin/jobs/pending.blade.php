<x-admin-layout title="Pending Job Listings">
  <div class="container mx-auto mt-5">
      <div class="bg-white shadow rounded-lg">
          <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg">
              <h3 class="text-lg font-semibold">Pending Job Listings</h3>
          </div>

          <!-- Job Listings Content -->
          <div class="mt-4">
              <div class="overflow-x-auto">
                  <table class="min-w-full border border-gray-200">
                      <thead class="bg-gray-800 text-white">
                          <tr>
                              <th class="px-4 py-2 border border-gray-300">Title</th>
                              <th class="px-4 py-2 border border-gray-300">Company</th>
                              <th class="px-4 py-2 border border-gray-300">Employer</th>
                              <th class="px-4 py-2 border border-gray-300">Posted Date</th>
                              <th class="px-4 py-2 border border-gray-300">Actions</th>
                          </tr>
                      </thead>
                      <tbody>
                          @forelse($pendingJobs as $job)
                              <tr class="hover:bg-gray-100">
                                  <td class="px-4 py-2 text-center">{{ $job->title }}</td>
                                  <td class="px-4 py-2 text-center">{{ $job->company->name }}</td>
                                  <td class="px-4 py-2 text-center">{{ $job->employer->name }}</td>
                                  <td class="px-4 py-2 text-center">{{ $job->created_at->format('M d, Y') }}</td>
                                  <td class="px-4 py-2 text-center">
                                      <div class="flex justify-center space-x-2">
                                          <a 
                                              href="{{ route('admin.jobs.show', $job->slug) }}" 
                                              class="text-white mr-2 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg"
                                          >
                                              <i class="fas fa-eye"></i> View Details
                                          </a>
                                          
                                          <form 
                                              action="{{ route('admin.jobs.approve', $job->id) }}" 
                                              method="POST" 
                                              class="inline"
                                          >
                                              @csrf
                                              <button type="submit" class="text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg">
                                                  <i class="fas fa-check"></i> Approve
                                              </button>
                                          </form>
                                          
                                          <form 
                                              action="{{ route('admin.jobs.destroy', $job->id) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirmReject(event)"
                                          >
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg">
                                                  <i class="fas fa-times"></i> Reject
                                              </button>
                                          </form>
                                      </div>
                                  </td>
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                      No pending job listings found
                                  </td>
                              </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
              
              <!-- Pagination -->
              <div class="mt-4 px-6">
                  {{ $pendingJobs->links() }}
              </div>
          </div>
      </div>
  </div>

  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
      function confirmReject(event) {
          event.preventDefault();
          
          Swal.fire({
              title: 'Are you sure?',
              text: 'Do you want to reject this job listing?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Yes, reject it!'
          }).then((result) => {
              if (result.isConfirmed) {
                  event.target.submit();
              }
          });
      }
  </script>
  @endpush
</x-admin-layout>