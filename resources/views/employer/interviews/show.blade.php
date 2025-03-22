<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Interview Details') }}
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
                      <a href="{{ route('employer.interviews.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                          &larr; {{ __('Back to All Interviews') }}
                      </a>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                      <!-- Interview Details -->
                      <div class="md:col-span-2">
                          <div class="bg-white rounded-lg shadow-md p-6">
                              <h3 class="text-lg font-semibold mb-4">{{ __('Interview Information') }}</h3>
                              
                              <div class="mb-4">
                                  <div class="flex justify-between items-center">
                                      <h4 class="font-medium text-gray-700">{{ __('Status') }}</h4>
                                      @if($interview->is_completed)
                                          <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                              {{ __('Completed') }}
                                          </span>
                                      @else
                                          @if(\Carbon\Carbon::parse($interview->scheduled_at)->isPast())
                                              <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                  {{ __('Overdue') }}
                                              </span>
                                          @else
                                              <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                  {{ __('Scheduled') }}
                                              </span>
                                          @endif
                                      @endif
                                  </div>
                              </div>
                              
                              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                  <div>
                                      <h4 class="font-medium text-gray-700">{{ __('Type') }}</h4>
                                      <p>{{ $interview->type }}</p>
                                  </div>
                                  
                                  <div>
                                      <h4 class="font-medium text-gray-700">{{ __('Date & Time') }}</h4>
                                      <p>{{ \Carbon\Carbon::parse($interview->scheduled_at)->format('M d, Y h:i A') }}</p>
                                  </div>
                              </div>

                              <div class="mb-4">
                                  <h4 class="font-medium text-gray-700">{{ __('Location / Meeting Link') }}</h4>
                                  <p>{{ $interview->location }}</p>
                              </div>

                              <div class="mb-4">
                                  <h4 class="font-medium text-gray-700">{{ __('Notes') }}</h4>
                                  <p class="whitespace-pre-line">{{ $interview->notes }}</p>
                              </div>

                              @if($interview->is_completed)
                                  <div class="mb-4">
                                      <h4 class="font-medium text-gray-700">{{ __('Outcome Notes') }}</h4>
                                      <p class="whitespace-pre-line">{{ $interview->outcome_notes }}</p>
                                  </div>
                              @endif

                              <div class="mt-6 flex justify-end space-x-3">
                                  @if(!$interview->is_completed)
                                      <a href="{{ route('employer.interviews.edit', $interview->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                          {{ __('Edit Interview') }}
                                      </a>
                                      
                                      <button type="button" id="complete-interview-btn" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                          {{ __('Mark Completed') }}
                                      </button>
                                  @endif
                              </div>
                          </div>
                      </div>

                      <!-- Side Panel -->
                      <div class="md:col-span-1">
                          <div class="bg-white rounded-lg shadow-md p-6">
                              <h3 class="text-lg font-semibold mb-4">{{ __('Candidate Information') }}</h3>
                              
                              <div class="mb-4">
                                  <h4 class="font-medium text-gray-700">{{ __('Name') }}</h4>
                                  <p>{{ $interview->application->candidate->name }}</p>
                              </div>
                              
                              <div class="mb-4">
                                  <h4 class="font-medium text-gray-700">{{ __('Email') }}</h4>
                                  <p>{{ $interview->application->candidate->email }}</p>
                              </div>
                              
                              <div class="mb-4">
                                  <h4 class="font-medium text-gray-700">{{ __('Phone') }}</h4>
                                  <p>{{ $interview->application->candidate->profile->phone ?? 'N/A' }}</p>
                              </div>
                              
                              <div class="mb-4">
                                  <h4 class="font-medium text-gray-700">{{ __('Applied For') }}</h4>
                                  <p>{{ $interview->application->job->title }}</p>
                              </div>
                              
                              <div class="mb-4">
                                  <h4 class="font-medium text-gray-700">{{ __('Application Status') }}</h4>
                                  <p>{{ ucfirst($interview->application->status) }}</p>
                              </div>
                              
                              <div class="mt-6">
                                  <a href="{{ route('employer.applications.show', ['job' => $interview->application->job_id, 'application' => $interview->application_id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 w-full justify-center">
                                      {{ __('View Application') }}
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- Completion Modal -->
  <div id="complete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
          <h3 class="text-lg font-semibold mb-4">{{ __('Mark Interview as Completed') }}</h3>
          
          <form action="{{ route('employer.interviews.complete', $interview->id) }}" method="POST">
              @csrf
              @method('PUT')
              
              <div class="mb-4">
                  <label for="outcome_notes" class="block text-sm font-medium text-gray-700">{{ __('Outcome Notes') }}</label>
                  <textarea id="outcome_notes" name="outcome_notes" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter interview feedback, notes, or next steps"></textarea>
              </div>
              
              <div class="flex justify-end space-x-3">
                  <button type="button" id="cancel-complete" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                      {{ __('Cancel') }}
                  </button>
                  
                  <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                      {{ __('Mark Completed') }}
                  </button>
              </div>
          </form>
      </div>
  </div>

  <script>
      document.addEventListener('DOMContentLoaded', function() {
          const completeBtn = document.getElementById('complete-interview-btn');
          const completeModal = document.getElementById('complete-modal');
          const cancelBtn = document.getElementById('cancel-complete');
          
          if (completeBtn) {
              completeBtn.addEventListener('click', function() {
                  completeModal.classList.remove('hidden');
              });
          }
          
          if (cancelBtn) {
              cancelBtn.addEventListener('click', function() {
                  completeModal.classList.add('hidden');
              });
          }
      });
  </script>
</x-app-layout>