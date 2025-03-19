<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Applications for') }}: {{ $job->title }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                  @if(session('success'))
                      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                          {{ session('success') }}
                      </div>
                  @endif

                  <div class="mb-6">
                      <a href="{{ route('employer.jobs.show', $job->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                          &larr; {{ __('Back to Job Details') }}
                      </a>
                  </div>

                  @if($applications->count() > 0)
                      <div class="overflow-x-auto">
                          <table class="min-w-full bg-white">
                              <thead class="bg-gray-100">
                                  <tr>
                                      <th class="py-3 px-4 text-left">{{ __('Candidate') }}</th>
                                      <th class="py-3 px-4 text-left">{{ __('Applied On') }}</th>
                                      <th class="py-3 px-4 text-left">{{ __('Status') }}</th>
                                      <th class="py-3 px-4 text-left">{{ __('Resume') }}</th>
                                      <th class="py-3 px-4 text-left">{{ __('Actions') }}</th>
                                  </tr>
                              </thead>
                              <tbody class="divide-y divide-gray-200">
                                  @foreach($applications as $application)
                                      <tr>
                                          <td class="py-3 px-4">
                                              {{ $application->candidate->name }}
                                          </td>
                                          <td class="py-3 px-4">
                                              {{ $application->created_at->format('M d, Y') }}
                                          </td>
                                          <td class="py-3 px-4">
                                              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                  @if($application->status == 'pending') bg-yellow-100 text-yellow-800 
                                                  @elseif($application->status == 'reviewing') bg-blue-100 text-blue-800 
                                                  @elseif($application->status == 'shortlisted') bg-green-100 text-green-800 
                                                  @elseif($application->status == 'rejected') bg-red-100 text-red-800 
                                                  @elseif($application->status == 'hired') bg-purple-100 text-purple-800 
                                                  @endif">
                                                  {{ ucfirst($application->status) }}
                                              </span>
                                          </td>
                                          <td class="py-3 px-4">
                                              @if($application->resume_path)
                                                  <a href="{{ route('employer.applications.download-resume', ['job' => $job->id, 'application' => $application->id]) }}" class="text-blue-600 hover:text-blue-900">
                                                      {{ __('Download') }}
                                                  </a>
                                              @else
                                                  <span class="text-gray-400">{{ __('No resume') }}</span>
                                              @endif
                                          </td>
                                          <td class="py-3 px-4">
                                              <div class="flex space-x-2">
                                                  <a href="{{ route('employer.applications.show', ['job' => $job->id, 'application' => $application->id]) }}" class="text-blue-600 hover:text-blue-900">
                                                      {{ __('View') }}
                                                  </a>
                                                  @if($application->status != 'rejected' && $application->status != 'hired')
                                                      <a href="{{ route('employer.interviews.create', ['job' => $job->id, 'application' => $application->id]) }}" class="text-green-600 hover:text-green-900">
                                                          {{ __('Schedule Interview') }}
                                                      </a>
                                                  @endif
                                              </div>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                      <div class="mt-4">
                          {{ $applications->links() }}
                      </div>
                  @else
                      <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-8 rounded text-center">
                          {{ __('No applications received for this job yet.') }}
                      </div>
                  @endif
              </div>
          </div>
      </div>
  </div>
</x-app-layout>