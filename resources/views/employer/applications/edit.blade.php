<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Edit Interview') }}
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
                      <a href="{{ route('employer.applications.show', ['job' => $interview->application->job_id, 'application' => $interview->application_id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                          &larr; {{ __('Back to Application') }}
                      </a>
                  </div>

                  <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                      <div class="flex">
                          <div>
                              <p class="text-sm text-blue-700">
                                  {{ __('Editing interview for') }} <strong>{{ $interview->application->candidate->name }}</strong> 
                                  {{ __('for the position of') }} <strong>{{ $interview->application->job->title }}</strong>
                              </p>
                          </div>
                      </div>
                  </div>

                  <form method="POST" action="{{ route('employer.interviews.update', $interview->id) }}">
                      @csrf
                      @method('PUT')
                      
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                          <!-- Interview Type -->
                          <div>
                              <x-input-label for="type" :value="__('Interview Type')" />
                              <select id="type" name="type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                  <option value="Phone" @if($interview->type == 'Phone') selected @endif>{{ __('Phone Screen') }}</option>
                                  <option value="Video" @if($interview->type == 'Video') selected @endif>{{ __('Video Interview') }}</option>
                                  <option value="In-person" @if($interview->type == 'In-person') selected @endif>{{ __('In-person Interview') }}</option>
                                  <option value="Technical" @if($interview->type == 'Technical') selected @endif>{{ __('Technical Assessment') }}</option>
                                  <option value="Team" @if($interview->type == 'Team') selected @endif>{{ __('Team Interview') }}</option>
                                  <option value="Final" @if($interview->type == 'Final') selected @endif>{{ __('Final Interview') }}</option>
                              </select>
                              <x-input-error :messages="$errors->get('type')" class="mt-2" />
                          </div>

                          <!-- Scheduled Date and Time -->
                          <div>
                              <x-input-label for="scheduled_at" :value="__('Date and Time')" />
                              <input id="scheduled_at" name="scheduled_at" type="datetime-local" 
                                  value="{{ \Carbon\Carbon::parse($interview->scheduled_at)->format('Y-m-d\TH:i') }}"
                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                              <x-input-error :messages="$errors->get('scheduled_at')" class="mt-2" />
                          </div>
                      </div>

                      <!-- Location / Link -->
                      <div class="mt-4">
                          <x-input-label for="location" :value="__('Location / Meeting Link')" />
                          <x-text-input id="location" name="location" type="text" class="block mt-1 w-full" :value="$interview->location" required />
                          <x-input-error :messages="$errors->get('location')" class="mt-2" />
                      </div>

                      <!-- Notes -->
                      <div class="mt-4">
                          <x-input-label for="notes" :value="__('Interview Notes / Instructions')" />
                          <textarea id="notes" name="notes" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $interview->notes }}</textarea>
                          <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                      </div>

                      <!-- Notify Candidate -->
                      <div class="mt-4">
                          <label class="inline-flex items-center">
                              <input type="checkbox" name="notify_candidate" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                              <span class="ml-2 text-sm text-gray-600">{{ __('Send update notification to candidate') }}</span>
                          </label>
                      </div>

                      <div class="flex items-center justify-between mt-4">
                          <form method="POST" action="{{ route('employer.interviews.destroy', $interview->id) }}" onsubmit="return confirm('{{ __('Are you sure you want to cancel this interview?') }}');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                  {{ __('Cancel Interview') }}
                              </button>
                          </form>
                          
                          <x-primary-button>
                              {{ __('Update Interview') }}
                          </x-primary-button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>