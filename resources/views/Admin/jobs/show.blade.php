<x-admin-layout title="Job Details">
  <div class="container mx-auto mt-5">
      <div class="bg-white shadow rounded-lg">
          <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
              <h3 class="text-lg font-semibold">Job Details</h3>
              <div class="flex space-x-2">
                  <a 
                      href="{{ route('admin.jobs.edit', $job->id) }}" 
                      class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg"
                  >
                      <i class="fas fa-edit"></i> Edit Job
                  </a>
                  <form 
                      action="{{ route('admin.jobs.destroy', $job->id) }}" 
                      method="POST" 
                      id="delete-form"
                      class="inline"
                  >
                      @csrf
                      @method('DELETE')
                      <button 
                          type="button" 
                          onclick="confirmDelete()"
                          class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg"
                      >
                          <i class="fas fa-trash"></i> Delete Job
                      </button>
                  </form>
              </div>
          </div>

          <div class="p-6">
              <div class="grid md:grid-cols-2 gap-6">
                  <div>
                      <h4 class="text-xl font-semibold mb-4">Job Information</h4>
                      <table class="w-full border-collapse">
                          <tr class="border-b">
                              <td class="py-2 font-medium">Title</td>
                              <td class="py-2">{{ $job->title }}</td>
                          </tr>
                          <tr class="border-b">
                              <td class="py-2 font-medium">Company</td>
                              <td class="py-2">{{ $job->company->name }}</td>
                          </tr>
                          <tr class="border-b">
                              <td class="py-2 font-medium">Category</td>
                              <td class="py-2">{{ $job->category->name }}</td>
                          </tr>
                          <tr class="border-b">
                              <td class="py-2 font-medium">Location</td>
                              <td class="py-2">{{ $job->location }}</td>
                          </tr>
                          <tr class="border-b">
                              <td class="py-2 font-medium">Work Type</td>
                              <td class="py-2">
                                  <span class="badge 
                                      {{ $job->work_type == 'remote' ? 'badge-primary' : 
                                         ($job->work_type == 'onsite' ? 'badge-secondary' : 'badge-accent') }}
                                  ">
                                      {{ ucfirst($job->work_type) }}
                                  </span>
                              </td>
                          </tr>
                          <tr class="border-b">
                              <td class="py-2 font-medium">Status</td>
                              <td class="py-2">
                                  @if(!$job->is_approved)
                                      <span class="badge badge-warning" >Pending Approval</span>
                                  @elseif(!$job->is_active)
                                      <span class="badge badge-error">Inactive</span>
                                  @else
                                      <span class="badge badge-success">Active</span>
                                  @endif
                              </td>
                          </tr>
                      </table>
                  </div>

                  <div>
                      <h4 class="text-xl font-semibold mb-4">Job Details</h4>
                      <div class="space-y-4">
                          <div>
                              <h5 class="font-medium mb-2">Description</h5>
                              <p class="text-gray-700">{{ $job->description }}</p>
                          </div>
                          <div>
                              <h5 class="font-medium mb-2">Responsibilities</h5>
                              <p class="text-gray-700">{{ $job->responsibilities }}</p>
                          </div>
                          <div>
                              <h5 class="font-medium mb-2">Requirements</h5>
                              <p class="text-gray-700">{{ $job->requirements }}</p>
                          </div>
                          {{-- <div>
                            <h5 class="font-medium mb-2">benefits</h5>
                            <p class="text-gray-700">{{ $job->benefits }}</p>
                        </div> --}}
                      </div>
                  </div>

                  
              </div>
          </div>
      </div>
  </div>

  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
      function confirmDelete() {
          Swal.fire({
              title: "Are you sure?",
              text: "You won't be able to revert this job deletion!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#d33",
              cancelButtonColor: "#3085d6",
              confirmButtonText: "Yes, delete it!"
          }).then((result) => {
              if (result.isConfirmed) {
                  document.getElementById('delete-form').submit();
              }
          });
      }
  </script>
  @endpush
</x-admin-layout>