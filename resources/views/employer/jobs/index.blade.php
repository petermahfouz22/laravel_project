<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Manage Jobs') }}
          </h2>
          <a href="{{ route('employer.jobs.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
              {{ __('Post New Job') }}
          </a>
          <a href="{{ route('employer.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-gray-700 transition">
            {{ __('My Dashboard') }}
        </a>
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          @if (session('success'))
              <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                  <span class="block sm:inline">{{ session('success') }}</span>
              </div>
          @endif

          @if(count($jobs) > 0)
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="p-6 bg-white border-b border-gray-200">
                      <div class="overflow-x-auto">
                          <table class="min-w-full bg-white">
                              <thead>
                                  <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                      <th class="py-3 px-6 text-left">Title</th>
                                      <th class="py-3 px-6 text-left">Company</th>
                                      <th class="py-3 px-6 text-left">Category</th>
                                      <th class="py-3 px-6 text-center">Applications</th>
                                      <th class="py-3 px-6 text-center">Status</th>
                                      <th class="py-3 px-6 text-center">Deadline</th>
                                      <th class="py-3 px-6 text-center">Actions</th>
                                  </tr>
                              </thead>
                              <tbody class="text-gray-600 text-sm">
                                  @foreach($jobs as $job)
                                      <tr class="border-b border-gray-200 hover:bg-gray-50">
                                          <td class="py-3 px-6 text-left">
                                              <a href="{{ route('employer.jobs.show', $job->id) }}" class="text-blue-600 hover:text-blue-800">
                                                  {{ $job->title }}
                                              </a>
                                          </td>
                                          <td class="py-3 px-6 text-left">{{ $job->company->name }}</td>
                                          <td class="py-3 px-6 text-left">{{ $job->category->name }}</td>
                                          <td class="py-3 px-6 text-center">
                                              <a href="{{ route('employer.applications.index', $job->id) }}" class="text-blue-600 hover:text-blue-800">
                                                  {{ $job->applications_count ?? 0 }}
                                              </a>
                                          </td>
                                          <td class="py-3 px-6 text-center">
                                              <span class="px-2 py-1 rounded-full text-xs {{ $job->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                  {{ $job->is_active ? 'Active' : 'Inactive' }}
                                              </span>
                                              <span class="px-2 py-1 rounded-full text-xs {{ $job->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                  {{ $job->is_approved ? 'Approved' : 'Pending' }}
                                              </span>
                                          </td>
                                          <td class="py-3 px-6 text-center">
                                              {{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}
                                          </td>
                                          <td class="py-3 px-6 text-center">
                                              <div class="flex justify-center items-center space-x-2">
                                                  <a href="{{ route('employer.jobs.edit', $job->id) }}" class="text-gray-500 hover:text-gray-700">
                                                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                      </svg>
                                                  </a>
                                                  
                                                  <form action="{{ route('employer.jobs.toggle-active', $job->id) }}" method="POST" class="inline">
                                                      @csrf
                                                      @method('PUT')
                                                      <button type="submit" class="text-{{ $job->is_active ? 'yellow' : 'green' }}-500 hover:text-{{ $job->is_active ? 'yellow' : 'green' }}-700" title="{{ $job->is_active ? 'Deactivate' : 'Activate' }}">
                                                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $job->is_active ? 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' }}"></path>
                                                          </svg>
                                                      </button>
                                                  </form>
                                                  
                                                  <form action="{{ route('employer.jobs.destroy', $job->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit" class="text-red-500 hover:text-red-700">
                                                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                          </svg>
                                                      </button>
                                                  </form>
                                              </div>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                      <div class="mt-4">
                          {{ $jobs->links() }}
                      </div>
                  </div>
              </div>
          @else
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="p-6 bg-white border-b border-gray-200">
                      <div class="text-center py-8">
                          <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                          </svg>
                          <h3 class="text-lg font-medium text-gray-900 mb-2">No jobs posted yet</h3>
                          <p class="text-gray-500 mb-6">Get started by creating your first job listing.</p>
                          <a href="{{ route('employer.jobs.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                              {{ __('Post a Job') }}
                          </a>
                      </div>
                  </div>
              </div>
          @endif
      </div>
  </div>
</x-app-layout>