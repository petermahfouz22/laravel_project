<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Job Details') }}
          </h2>
          <div class="flex space-x-2">
              <a href="{{ route('employer.applications.index', $job->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                  {{ __('View Applications') }} ({{ $job->applications->count() }})
              </a>
              <a href="{{ route('employer.jobs.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                  {{ __('← Back to Jobs') }}
              </a>
          </div>
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
              <div class="p-6 bg-white border-b border-gray-200">
                  <!-- Job Status and Actions -->
                  <div class="flex justify-between items-center mb-6">
                      <div class="flex space-x-2">
                          <span class="px-3 py-1 rounded-full text-sm {{ $job->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                              {{ $job->is_active ? 'Active' : 'Inactive' }}
                          </span>
                          <span class="px-3 py-1 rounded-full text-sm {{ $job->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                              {{ $job->is_approved ? 'Approved' : 'Pending Approval' }}
                          </span>
                      </div>
                      <div class="flex space-x-2">
                          <form action="{{ route('employer.jobs.toggle-active', $job->id) }}" method="POST" class="inline">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="px-4 py-2 bg-{{ $job->is_active ? 'yellow' : 'green' }}-600 text-white rounded-md hover:bg-{{ $job->is_active ? 'yellow' : 'green' }}-700 transition">
                                  {{ $job->is_active ? 'Deactivate' : 'Activate' }}
                              </button>
                          </form>
                          <a href="{{ route('employer.jobs.edit', $job->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                              {{ __('Edit Job') }}
                          </a>
                      </div>
                  </div>

                  <!-- Job Overview -->
                  <div class="mb-8">
                      <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $job->title }}</h1>
                      <div class="flex flex-wrap items-center text-gray-600 mb-4">
                          <div class="mr-6 mb-2">
                              <span class="font-medium">Company:</span> {{ $job->company->name }}
                          </div>
                          <div class="mr-6 mb-2">
                              <span class="font-medium">Category:</span> {{ $job->category->name }}
                          </div>
                          <div class="mr-6 mb-2">
                              <span class="font-medium">Location:</span> {{ $job->location }}
                          </div>
                          <div class="mr-6 mb-2">
                              <span class="font-medium">Work Type:</span> {{ ucfirst($job->work_type) }}
                          </div>
                          <div class="mr-6 mb-2">
                              <span class="font-medium">Deadline:</span> {{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}
                          </div>
                          <div class="mb-2">
                              <span class="font-medium">Salary:</span> 
                              @if($job->salary_min && $job->salary_max)
                                  ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                              @elseif($job->salary_min)
                                  From ${{ number_format($job->salary_min) }}
                              @elseif($job->salary_max)
                                  Up to ${{ number_format($job->salary_max) }}
                              @else
                                  Not specified
                              @endif
                          </div>
                      </div>

                      @if($job->technologies->count() > 0)
                          <div class="mb-4">
                              <span class="font-medium text-gray-600">Technologies:</span>
                              <div class="flex flex-wrap mt-2">
                                  @foreach($job->technologies as $technology)
                                      <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm mr-2 mb-2">{{ $technology->name }}</span>
                                  @endforeach
                              </div>
                          </div>
                      @endif
                  </div>

                  <!-- Job Details -->
                  <div class="space-y-8">
                      <div>
                          <h2 class="text-xl font-semibold text-gray-800 mb-3">Job Description</h2>
                          <div class="prose max-w-none">
                              {!! nl2br(e($job->description)) !!}
                          </div>
                      </div>

                      <div>
                          <h2 class="text-xl font-semibold text-gray-800 mb-3">Responsibilities</h2>
                          <div class="prose max-w-none">
                              {!! nl2br(e($job->responsibilities)) !!}
                          </div>
                      </div>

                      <div>
                          <h2 class="text-xl font-semibold text-gray-800 mb-3">Requirements</h2>
                          <div class="prose max-w-none">
                              {!! nl2br(e($job->requirements)) !!}
                          </div>
                      </div>

                      @if($job->benefits)
                          <div>
                              <h2 class="text-xl font-semibold text-gray-800 mb-3">Benefits</h2>
                              <div class="prose max-w-none">
                                  {!! nl2br(e($job->benefits)) !!}
                              </div>
                          </div>
                      @endif
                  </div>
              </div>
          </div>

          <!-- Recent Applications Section -->
          @if($job->applications->count() > 0)
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="p-6 bg-white border-b border-gray-200">
                      <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Applications ({{ $job->applications->count() }})</h2>
                      <div class="overflow-x-auto">
                          <table class="min-w-full bg-white">
                              <thead>
                                  <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                      <th class="py-3 px-6 text-left">Candidate</th>
                                      <th class="py-3 px-6 text-left">Applied On</th>
                                      <th class="py-3 px-6 text-center">Status</th>
                                      <th class="py-3 px-6 text-center">Actions</th>
                                  </tr>
                              </thead>
                              <tbody class="text-gray-600 text-sm">
                                  @foreach($job->applications->sortByDesc('created_at')->take(5) as $application)
                                      <tr class="border-b border-gray-200 hover:bg-gray-50">
                                          <td class="py-3 px-6 text-left">
                                            {{ $application->candidate?->user?->name ?? 'N/A' }}                                          </td>
                                          <td class="py-3 px-6 text-left">
                                              {{ $application->created_at->format('M d, Y') }}
                                          </td>
                                          <td class="py-3 px-6 text-center">
                                              <span class="px-2 py-1 rounded-full text-xs 
                                                  @if($application->status == 'pending') bg-yellow-100 text-yellow-800
                                                  @elseif($application->status == 'reviewing') bg-blue-100 text-blue-800
                                                  @elseif($application->status == 'shortlisted') bg-green-100 text-green-800
                                                  @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                                  @elseif($application->status == 'hired') bg-purple-100 text-purple-800
                                                  @endif
                                              ">
                                                  {{ ucfirst($application->status) }}
                                              </span>
                                          </td>
                                          <td class="py-3 px-6 text-center">
                                              <a href="{{ route('employer.applications.show', [$job->id, $application->id]) }}" class="text-blue-600 hover:text-blue-900">
                                                  View Details
                                              </a>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                      @if($job->applications->count() > 5)
                          <div class="mt-4 text-right">
                              <a href="{{ route('employer.applications.index', $job->id) }}" class="text-blue-600 hover:underline">
                                  View all applications →
                              </a>
                          </div>
                      @endif
                  </div>
              </div>
          @endif
      </div>
  </div>
</x-app-layout>