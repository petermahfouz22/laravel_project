<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Edit Interview') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <div class="mb-6">
                      <h3 class="text-lg font-medium text-gray-900">
                          Interview with {{ $interview->application->candidate->name }} for {{ $interview->application->job->title }}
                      </h3>
                      <p class="mt-1 text-sm text-gray-600">
                          Application submitted on {{ $interview->application->created_at->format('M d, Y') }}
                      </p>
                  </div>

                  <form method="POST" action="{{ route('employer.interviews.update', $interview->id) }}">
                      @csrf
                      @method('PUT')

                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                          <!-- Interview Date and Time -->
                          <div>
                              <x-input-label for="scheduled_at" :value="__('Interview Date & Time')" />
                              <x-text-input id="scheduled_at" class="block mt-1 w-full" type="datetime-local" name="scheduled_at" :value="old('scheduled_at', $interview->scheduled_at->format('Y-m-d\TH:i'))" required />
                              <x-input-error :messages="$errors->get('scheduled_at')" class="mt-2" />
                          </div>

                          <!-- Duration (minutes) -->
                          <div>
                              <x-input-label for="duration" :value="__('Duration (minutes)')" />
                              <x-text-input id="duration" class="block mt-1 w-full" type="number" name="duration" :value="old('duration', $interview->duration)" required />
                              <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                          </div>
                      </div>

                      <div class="mt-6">
                          <!-- Online Interview -->
                          <div class="block">
                              <label for="is_online" class="flex items-center">
                                  <input id="is_online" type="checkbox" name="is_online" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $interview->is_online ? 'checked' : '' }}>
                                  <span class="ml-2 text-sm text-gray-600">{{ __('This is an online interview') }}</span>
                              </label>
                          </div>
                      </div>

                      <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                          <!-- Location -->
                          <div>
                              <x-input-label for="location" :value="__('Location')" />
                              <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $interview->location)" />
                              <x-input-error :messages="$errors->get('location')" class="mt-2" />
                              <p class="mt-1 text-sm text-gray-500">For in-person interviews, specify the address</p>
                          </div>

                          <!-- Meeting Link -->
                          <div>
                              <x-input-label for="meeting_link" :value="__('Meeting Link')" />
                              <x-text-input id="meeting_link" class="block mt-1 w-full" type="url" name="meeting_link" :value="old('meeting_link', $interview->meeting_link)" />
                              <x-input-error :messages="$errors->get('meeting_link')" class="mt-2" />
                              <p class="mt-1 text-sm text-gray-500">For online interviews, provide the meeting URL</p>
                          </div>
                      </div>

                      <!-- Notes -->
                      <div class="mt-6">
                          <x-input-label for="notes" :value="__('Notes')" />
                          <textarea id="notes" name="notes" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('notes', $interview->notes) }}</textarea>
                          <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                          <p class="mt-1 text-sm text-gray-500">Additional information to prepare for the interview</p>
                      </div>

                      <div class="flex items-center justify-between mt-6">
                          <div>
                              <a href="{{ route('employer.interviews.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                  {{ __('Cancel') }}
                              </a>
                          </div>
                          <div class="flex space-x-2">
                              <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                  {{ __('Update Interview') }}
                              </button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>