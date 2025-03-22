<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Manage Interviews') }}
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
                      <a href="{{ route('employer.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-gray-700">
                          &larr; {{ __('Back to Dashboard') }}
                      </a>
                  </div>

                  <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                      <h3 class="text-lg font-semibold">{{ __('Your Interviews') }}</h3>
                      <div class="flex flex-col md:flex-row items-center gap-3">
                          <div>
                              <select id="interview-filter" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                  <option value="all">{{ __('All Interviews') }}</option>
                                  <option value="upcoming">{{ __('Upcoming') }}</option>
                                  <option value="completed">{{ __('Completed') }}</option>
                              </select>
                          </div>
                      </div>
                  </div>

                  @if($interviews->count() > 0)
                      <div class="overflow-x-auto bg-white rounded-lg shadow">
                          <table class="min-w-full divide-y divide-gray-200">
                              <thead class="bg-gray-50">
                                  <tr>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          {{ __('Candidate') }}
                                      </th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          {{ __('Job Position') }}
                                      </th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          {{ __('Type') }}
                                      </th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          {{ __('Date & Time') }}
                                      </th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          {{ __('Status') }}
                                      </th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          {{ __('Actions') }}
                                      </th>
                                  </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                  @foreach($interviews as $interview)
                                      @php
                                          $isPast = \Carbon\Carbon::parse($interview->scheduled_at)->isPast();
                                          $isScheduled = !$isPast && !$interview->is_completed;
                                          $isOverdue = $isPast && !$interview->is_completed;
                                      @endphp
                                      <tr class="interview-row @if($interview->is_completed) completed @elseif($isOverdue) overdue @else upcoming @endif">
                                          <td class="px-6 py-4 whitespace-nowrap">
                                              <div class="text-sm font-medium text-gray-900">
                                                  {{ $interview->application->candidate->name }}
                                              </div>
                                              <div class="text-sm text-gray-500">
                                                  {{ $interview->application->candidate->email }}
                                              </div>
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap">
                                              <div class="text-sm text-gray-900">
                                                  {{ $interview->application->job->title }}
                                              </div>
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap">
                                              <div class="text-sm text-gray-900">
                                                  {{ $interview->type }}
                                              </div>
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap">
                                              <div class="text-sm text-gray-900">
                                                  {{ \Carbon\Carbon::parse($interview->scheduled_at)->format('M d, Y') }}
                                              </div>
                                              <div class="text-sm text-gray-500">
                                                  {{ \Carbon\Carbon::parse($interview->scheduled_at)->format('h:i A') }}
                                              </div>
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap">
                                              @if($interview->is_completed)
                                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                      {{ __('Completed') }}
                                                  </span>
                                              @elseif($isOverdue)
                                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                      {{ __('Overdue') }}
                                                  </span>
                                              @else
                                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                      {{ __('Upcoming') }}
                                                  </span>
                                              @endif
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                              <div class="flex flex-col md:flex-row md:space-x-2 space-y-1 md:space-y-0">
                                                  <a href="{{ route('employer.interviews.show', $interview->id) }}" class="text-blue-600 hover:text-blue-900">
                                                      {{ __('View') }}
                                                  </a>
                                                  @if(!$interview->is_completed)
                                                      <a href="{{ route('employer.interviews.edit', $interview->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                          {{ __('Edit') }}
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
                          {{ $interviews->links() }}
                      </div>
                  @else
                      <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-8 rounded text-center">
                          <p class="font-medium">{{ __('No interviews scheduled yet.') }}</p>
                          <p class="mt-2">{{ __('When you schedule interviews with candidates, they will appear here.') }}</p>
                      </div>
                  @endif
              </div>
          </div>
      </div>
  </div>

  <script>
      document.addEventListener('DOMContentLoaded', function() {
          const filter = document.getElementById('interview-filter');
          
          filter.addEventListener('change', function() {
              const value = this.value;
              const rows = document.querySelectorAll('.interview-row');
              
              rows.forEach(row => {
                  if (value === 'all') {
                      row.style.display = '';
                  } else if (value === 'upcoming' && row.classList.contains('upcoming')) {
                      row.style.display = '';
                  } else if (value === 'completed' && row.classList.contains('completed')) {
                      row.style.display = '';
                  } else {
                      row.style.display = 'none';
                  }
              });
          });
      });
  </script>
</x-app-layout>