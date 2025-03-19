<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Employer Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <!-- Quick Statistics -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
              <div class="bg-white p-6 rounded-lg shadow">
                  <h2 class="text-lg font-semibold text-gray-700">Published Jobs</h2>
                  <p class="text-3xl font-bold text-blue-600">{{ $jobsCount }}</p>
              </div>
              
              <div class="bg-white p-6 rounded-lg shadow">
                  <h2 class="text-lg font-semibold text-gray-700">Active Jobs</h2>
                  <p class="text-3xl font-bold text-green-600">{{ $activeJobsCount }}</p>
              </div>
              
              <div class="bg-white p-6 rounded-lg shadow">
                  <h2 class="text-lg font-semibold text-gray-700">Received Applications</h2>
                  <p class="text-3xl font-bold text-purple-600">{{ $applicationsCount }}</p>
              </div>
          </div>

          <!-- Recent Applications -->
          <div class="bg-white p-6 rounded-lg shadow mb-8">
              <h2 class="text-xl font-semibold mb-4">Latest Applications</h2>
              
              @if($recentApplications->count() > 0)
                  <div class="overflow-x-auto">
                      <table class="w-full table-auto">
                          <thead>
                              <tr class="bg-gray-100">
                                  <th class="px-4 py-2 text-left">Applicant</th>
                                  <th class="px-4 py-2 text-left">Job</th>
                                  <th class="px-4 py-2 text-left">Application Date</th>
                                  <th class="px-4 py-2 text-left">Status</th>
                                  <th class="px-4 py-2 text-center">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($recentApplications as $application)
                                  <tr class="border-b hover:bg-gray-50">
                                      <td class="px-4 py-3">{{ $application->candidate->name }}</td>
                                      <td class="px-4 py-3">{{ $application->job->title }}</td>
                                      <td class="px-4 py-3">{{ $application->created_at->format('Y-m-d') }}</td>
                                      <td class="px-4 py-3">
                                          @if($application->status == 'pending')
                                              <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Pending</span>
                                          @elseif($application->status == 'reviewing')
                                              <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Reviewing</span>
                                          @elseif($application->status == 'shortlisted')
                                              <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Shortlisted</span>
                                          @elseif($application->status == 'rejected')
                                              <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Rejected</span>
                                          @elseif($application->status == 'hired')
                                              <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Hired</span>
                                          @endif
                                      </td>
                                      <td class="px-4 py-3 text-center">
                                          <a href="{{ route('employer.applications.show', ['job' => $application->job->id, 'application' => $application->id]) }}" 
                                             class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                             View Details
                                          </a>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                      
                      <!-- Pagination Links -->
                      <div class="mt-4">
                          {{ $recentApplications->links() }}
                      </div>
                  </div>
              @else
                  <p class="text-gray-500">No recent applications.</p>
              @endif
              
              <div class="mt-4 text-right">
                  <a href="{{ route('employer.jobs.create') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                      Post New Job
                  </a>
              </div>
          </div>

          <!-- Quick Links -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="bg-white p-6 rounded-lg shadow">
                  <h2 class="text-xl font-semibold mb-4">Job Management</h2>
                  <ul class="space-y-2">
                      <li>
                          <a href="{{ route('employer.jobs.index') }}" class="text-blue-600 hover:underline block p-2 hover:bg-gray-50 rounded">
                              View All Jobs
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('employer.jobs.create') }}" class="text-blue-600 hover:underline block p-2 hover:bg-gray-50 rounded">
                              Add New Job
                          </a>
                      </li>
                  </ul>
              </div>
              
              <div class="bg-white p-6 rounded-lg shadow">
                  <h2 class="text-xl font-semibold mb-4">Company Profile</h2>
                  <ul class="space-y-2">
                      <li>
                          <a href="{{ route('employer.companies.index') }}" class="text-blue-600 hover:underline block p-2 hover:bg-gray-50 rounded">
                              View Company Profile
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('employer.companies.create') }}" class="text-blue-600 hover:underline block p-2 hover:bg-gray-50 rounded">
                              Update Company Information
                          </a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>