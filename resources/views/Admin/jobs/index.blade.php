<x-admin-layout title="Manage Job Listings">
  <div class="container mx-auto mt-5">
      <div class="bg-white shadow rounded-lg">
          <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg">
              <h3 class="text-lg font-semibold">Job Listings</h3>
          </div>
          
          <!-- Search and Filter Form -->
          <div class="p-6 border-b border-gray-200">
              <form action="{{ route('admin.jobs.index') }}" method="GET" class="mb-4">
                  <div class="grid md:grid-cols-3 gap-4">
                      <input 
                          type="text" 
                          name="search" 
                          placeholder="Search jobs..." 
                          value="{{ request('search') }}"
                          class="input input-bordered w-full"
                      >
                      
                      <select name="category" class="select select-bordered w-full">
                          <option value="">All Categories</option>
                          @foreach($categories as $cat)
                              <option 
                                  value="{{ $cat->id }}" 
                                  {{ request('category') == $cat->id ? 'selected' : '' }}
                              >
                                  {{ $cat->name }}
                              </option>
                          @endforeach
                      </select>

                      <select name="work_type" class="select select-bordered w-full">
                          <option value="">All Work Types</option>
                          <option value="remote" {{ request('work_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                          <option value="onsite" {{ request('work_type') == 'onsite' ? 'selected' : '' }}>On-site</option>
                          <option value="hybrid" {{ request('work_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                      </select>
                  </div>
                  
                  <div class="grid md:grid-cols-3 gap-4 mt-4">
                      <input 
                          type="text" 
                          name="location" 
                          placeholder="Location" 
                          value="{{ request('location') }}"
                          class="input input-bordered w-full"
                      >

                      <select name="technology" class="select select-bordered w-full">
                          <option value="">All Technologies</option>
                          @foreach($technologies as $tech)
                              <option 
                                  value="{{ $tech->id }}" 
                                  {{ request('technology') == $tech->id ? 'selected' : '' }}
                              >
                                  {{ $tech->name }}
                              </option>
                          @endforeach
                      </select>

                      <button type="submit" class="btn btn-primary w-full">
                          Apply Filters
                      </button>
                  </div>
              </form>
          </div>

          <!-- Tabs for Job Status -->
          <div class="flex border-b border-gray-200">
              <button class="tab-button px-4 py-2 text-blue-600 border-b-2 border-blue-600 font-medium focus:outline-none active" data-tab="allJobs">
                  All Jobs
              </button>
              <button class="tab-button px-4 py-2 text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 font-medium focus:outline-none" data-tab="pendingJobs">
                  Pending Approval
              </button>
              <button class="tab-button px-4 py-2 text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 font-medium focus:outline-none" data-tab="activeJobs">
                  Active Jobs
              </button>
              <button class="tab-button px-4 py-2 text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 font-medium focus:outline-none" data-tab="inactiveJobs">
                  Inactive Jobs
              </button>
          </div>

          <!-- Job Listings Content -->
          <div id="jobTabsContent" class="mt-4">
              <div class="tab-content" id="allJobs">
                  <div class="overflow-x-auto">
                      <table class="min-w-full border border-gray-200">
                          <thead class="bg-gray-800 text-white">
                              <tr>
                                  <th class="px-4 py-2 border border-gray-300">Title</th>
                                  <th class="px-4 py-2 border border-gray-300">Company</th>
                                  <th class="px-4 py-2 border border-gray-300">Category</th>
                                  <th class="px-4 py-2 border border-gray-300">Location</th>
                                  <th class="px-4 py-2 border border-gray-300">Status</th>
                                  <th class="px-4 py-2 border border-gray-300">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              @forelse($jobs as $job)
                                  <tr class="hover:bg-gray-100">
                                      <td class="px-4 py-2 text-center">{{ $job->title }}</td>
                                      <td class="px-4 py-2 text-center">{{ $job->company->name }}</td>
                                      <td class="px-4 py-2 text-center">{{ $job->category->name }}</td>
                                      <td class="px-4 py-2 text-center">{{ $job->location }}</td>
                                      <td class="px-4 py-2 text-center">
                                          @if(!$job->is_approved)
                                              <span class="badge badge-warning">Pending</span>
                                          @elseif(!$job->is_active)
                                              <span class="badge badge-error">Inactive</span>
                                          @else
                                              <span class="badge badge-success">Active</span>
                                          @endif
                                      </td>
                                      <td class="px-4 py-2 text-center">
                                          <div class="flex justify-center space-x-2">
                                              <a 
                                                  href="{{ route('admin.jobs.show', $job->slug) }}" 
                                                  class="text-white mr-2 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg"
                                              >
                                                  <i class="fas fa-eye"></i> View
                                              </a>
                                              @if(!$job->is_approved)
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
                                              @endif
                                          </div>
                                      </td>
                                  </tr>
                              @empty
                                  <tr>
                                      <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                          No job listings found
                                      </td>
                                  </tr>
                              @endforelse
                          </tbody>
                      </table>
                  </div>
                  
                  <!-- Pagination -->
                  <div class="mt-4 px-6">
                      {{ $jobs->appends(request()->query())->links() }}
                  </div>
              </div>
          </div>
      </div>
  </div>

  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
      document.addEventListener('DOMContentLoaded', function () {
          const tabButtons = document.querySelectorAll('.tab-button');
          const tabContents = document.querySelectorAll('.tab-content');
          
          tabButtons.forEach(button => {
              button.addEventListener('click', function (event) {
                  event.preventDefault();
                  
                  // Reset all tab buttons
                  tabButtons.forEach(btn => {
                      btn.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600', 'active');
                      btn.classList.add('text-gray-600', 'hover:text-blue-600', 'hover:border-b-2', 'hover:border-blue-600');
                  });
                  
                  // Activate current tab button
                  this.classList.remove('text-gray-600', 'hover:text-blue-600', 'hover:border-b-2', 'hover:border-blue-600');
                  this.classList.add('text-blue-600', 'border-b-2', 'border-blue-600', 'active');
                  
                  // Hide all tab contents
                  tabContents.forEach(content => content.classList.add('hidden'));
                  
                  // Show selected tab content
                  const tabId = this.getAttribute('data-tab');
                  const selectedTab = document.getElementById(tabId);
                  if (selectedTab) selectedTab.classList.remove('hidden');
              });
          });
          
          // Initially hide all tab contents except the first one
          tabContents.forEach(content => content.classList.add('hidden'));
          document.getElementById('allJobs').classList.remove('hidden');
      });
  </script>
  @endpush
</x-admin-layout>