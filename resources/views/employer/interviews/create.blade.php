<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Schedule Interview') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                  <div class="mb-6">
                      <a href="{{ route('employer.applications.show', ['job' => $job->id, 'application' => $application->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                          &larr; {{ __('Back to Application') }}
                      </a>
                  </div>

                  <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                      <div class="flex">
                          <div class="flex-shrink-0">
                              <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                              </svg>
                          </div>
                          <div class="ml-3">
                              <p class="text-sm text-blue-700">
                                  {{ __('Scheduling interview for') }} <strong>{{ $application->candidate->name }}</strong> 
                                  {{ __('for the position of') }} <strong>{{ $job->title }}</strong>
                              </p>
                          </div>
                      </div>
                  </div>

                  <form method="POST" action="{{ route('employer.interviews.store', ['job' => $job->id, 'application' => $application->id]) }}" class="bg-white rounded-lg shadow-md p-6">
                      @csrf
                      
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                          <!-- Interview Type -->
                          <div>
                              <x-input-label for="type" :value="__('Interview Type')" />
                              <select id="type" name="type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                  <option value="Phone">{{ __('Phone Screen') }}</option>
                                  <option value="Video">{{ __('Video Interview') }}</option>
                                  <option value="In-person">{{ __('In-person Interview') }}</option>
                                  <option value="Technical">{{ __('Technical Assessment') }}</option>
                                  <option value="Team">{{ __('Team Interview') }}</option>
                                  <option value="Final">{{ __('Final Interview') }}</option>
                              </select>
                              <x-input-error :messages="$errors->get('type')" class="mt-2" />
                          </div>

                          <!-- Scheduled Date and Time -->
                          <div>
                              <x-input-label for="scheduled_at" :value="__('Date and Time')" />
                              <input id="scheduled_at" name="scheduled_at" type="datetime-local" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                              <x-input-error :messages="$errors->get('scheduled_at')" class="mt-2" />
                          </div>
                      </div>

                      <div class="mt-4">
                          <x-input-label for="duration" :value="__('Duration (minutes)')" />
                          <select id="duration" name="duration" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                              <option value="15">15 minutes</option>
                              <option value="30" selected>30 minutes</option>
                              <option value="45">45 minutes</option>
                              <option value="60">60 minutes</option>
                              <option value="90">90 minutes</option>
                              <option value="120">120 minutes</option>
                          </select>
                          <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                      </div>

                      <!-- Is Online -->
                      <div class="mt-4">
                          <label class="inline-flex items-center">
                              <input type="checkbox" id="is_online" name="is_online" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                              <span class="ml-2 text-sm text-gray-600">{{ __('This is an online interview') }}</span>
                          </label>
                      </div>

                      <!-- Location / Link -->
                      <div class="mt-4">
                          <x-input-label for="location" :value="__('Location / Meeting Link')" />
                          <x-text-input id="location" name="location" type="text" class="block mt-1 w-full" required />
                          <x-input-error :messages="$errors->get('location')" class="mt-2" />
                          <p class="text-sm text-gray-500 mt-1">
                              {{ __('For phone interviews: enter phone number. For video: enter meeting link. For in-person: enter address.') }}
                          </p>
                      </div>

                      <!-- Meeting Link (for online interviews) -->
                      <div id="meeting-link-container" class="mt-4 hidden">
                          <x-input-label for="meeting_link" :value="__('Meeting Link')" />
                          <x-text-input id="meeting_link" name="meeting_link" type="text" class="block mt-1 w-full" />
                          <x-input-error :messages="$errors->get('meeting_link')" class="mt-2" />
                      </div>

                      <!-- Notes -->
                      <div class="mt-4">
                          <x-input-label for="notes" :value="__('Interview Notes / Instructions')" />
                          <textarea id="notes" name="notes" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                          <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                          <p class="text-sm text-gray-500 mt-1">
                              {{ __('Include any preparation instructions or details the candidate should know.') }}
                          </p>
                      </div>

                      <!-- Notify Candidate -->
                      <div class="mt-4">
                          <label class="inline-flex items-center">
                              <input type="checkbox" name="notify_candidate" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" checked>
                              <span class="ml-2 text-sm text-gray-600">{{ __('Send notification email to candidate') }}</span>
                          </label>
                      </div>

                      <div class="flex items-center justify-end mt-6">
                          <x-primary-button>
                              {{ __('Schedule Interview') }}
                          </x-primary-button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <script>
      document.addEventListener('DOMContentLoaded', function() {
          const isOnlineCheckbox = document.getElementById('is_online');
          const meetingLinkContainer = document.getElementById('meeting-link-container');
          const locationInput = document.getElementById('location');
          const typeSelect = document.getElementById('type');
          
          function updateFields() {
              const isOnline = isOnlineCheckbox.checked;
              const interviewType = typeSelect.value;
              
              if (isOnline) {
                  meetingLinkContainer.classList.remove('hidden');
                  locationInput.placeholder = 'Enter virtual meeting room name or description';
              } else {
                  meetingLinkContainer.classList.add('hidden');
                  
                  if (interviewType === 'Phone') {
                      locationInput.placeholder = 'Enter phone number';
                  } else if (interviewType === 'In-person') {
                      locationInput.placeholder = 'Enter physical address';
                  } else {
                      locationInput.placeholder = 'Enter meeting location';
                  }
              }
          }
          
          isOnlineCheckbox.addEventListener('change', updateFields);
          typeSelect.addEventListener('change', updateFields);
          
          // Initial update
          updateFields();
      });
  </script>
</x-app-layout>