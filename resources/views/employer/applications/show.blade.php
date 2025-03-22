<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Application Details') }}
        </h2>
        <a href="{{ route('employer.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-gray-700 transition">
            {{ __('My Dashboard') }}
        </a>
    </div>
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

                  <div class="mb-6 flex justify-between">
                      <a href="{{ route('employer.applications.index', $job->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                          &larr; {{ __('Back to Applications') }}
                      </a>
                      
                      @if($application->resume_path)
                          <a href="{{ route('employer.applications.download-resume', ['job' => $job->id, 'application' => $application->id]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                              {{ __('Download Resume') }}
                          </a>
                      @endif
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                      <!-- Candidate Information -->
                      <div class="md:col-span-1 bg-gray-50 p-4 rounded-lg">
                          <h3 class="font-bold text-lg mb-2">{{ __('Candidate Information') }}</h3>
                          <div class="space-y-2">
                              <div>
                                  <span class="font-semibold">{{ __('Name') }}:</span>
                                  <span>{{ $application->candidate->name }}</span>
                              </div>
                              <div>
                                  <span class="font-semibold">{{ __('Email') }}:</span>
                                  <span>{{ $application->candidate->email }}</span>
                              </div>
                              @if($application->candidate->phone)
                              <div>
                                  <span class="font-semibold">{{ __('Phone') }}:</span>
                                  <span>{{ $application->candidate->phone }}</span>
                              </div>
                              @endif
                              <div>
                                  <span class="font-semibold">{{ __('Applied On') }}:</span>
                                  <span>{{ $application->created_at->format('M d, Y h:i A') }}</span>
                              </div>
                              <div>
                                  <div class="mt-4">
                                      <span class="font-semibold">{{ __('Current Status') }}:</span>
                                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                          @if($application->status == 'pending') bg-yellow-100 text-yellow-800 
                                          @elseif($application->status == 'reviewing') bg-blue-100 text-blue-800 
                                          @elseif($application->status == 'shortlisted') bg-green-100 text-green-800 
                                          @elseif($application->status == 'rejected') bg-red-100 text-red-800 
                                          @elseif($application->status == 'hired') bg-purple-100 text-purple-800 
                                          @endif">
                                          {{ ucfirst($application->status) }}
                                      </span>
                                  </div>
                              </div>
                          </div>
                          
                          <div class="mt-6">
                              <h4 class="font-bold text-md mb-2">{{ __('Update Status') }}</h4>
                              <form action="{{ route('employer.applications.update-status', ['job' => $job->id, 'application' => $application->id]) }}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <div class="mb-3">
                                      <select name="status" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                          <option value="pending" @if($application->status == 'pending') selected @endif>{{ __('Pending') }}</option>
                                          <option value="reviewing" @if($application->status == 'reviewing') selected @endif>{{ __('Reviewing') }}</option>
                                          <option value="shortlisted" @if($application->status == 'shortlisted') selected @endif>{{ __('Shortlisted') }}</option>
                                          <option value="rejected" @if($application->status == 'rejected') selected @endif>{{ __('Rejected') }}</option>
                                          <option value="hired" @if($application->status == 'hired') selected @endif>{{ __('Hired') }}</option>
                                      </select>
                                  </div>
                                  <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                      {{ __('Update Status') }}
                                  </button>
                              </form>
                          </div>
                      </div>

                      <!-- Application Details -->
                      <div class="md:col-span-2">
                          <div class="bg-white p-4 rounded-lg border border-gray-200 mb-6">
                              <h3 class="font-bold text-lg mb-3">{{ __('Job Application') }}</h3>
                              
                              <div class="mb-4">
                                  <h4 class="font-semibold text-md mb-1">{{ __('Cover Letter') }}</h4>
                                  <div class="bg-gray-50 p-3 rounded">
                                      {!! nl2br(e($application->cover_letter)) !!}
                                  </div>
                              </div>
                              
                              @if($application->answers)
                                  <div class="mb-4">
                                      <h4 class="font-semibold text-md mb-1">{{ __('Screening Questions') }}</h4>
                                      <div class="space-y-3">
                                          @foreach(json_decode($application->answers, true) as $question => $answer)
                                              <div class="bg-gray-50 p-3 rounded">
                                                  <p class="font-medium">{{ $question }}</p>
                                                  <p>{{ $answer }}</p>
                                              </div>
                                          @endforeach
                                      </div>
                                  </div>
                              @endif
                          </div>
                          
                          <!-- Interviews Section -->
                          <div class="bg-white p-4 rounded-lg border border-gray-200">
                              <div class="flex justify-between items-center mb-3">
                                  <h3 class="font-bold text-lg">{{ __('Interviews') }}</h3>
                                  @if($application->status != 'rejected')
                                      <a href="{{ route('employer.interviews.create', ['job' => $job->id, 'application' => $application->id]) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                          {{ __('Schedule Interview') }}
                                      </a>
                                  @endif
                              </div>
                              
                              @if($interviews->count() > 0)
                                  <div class="space-y-4">
                                      @foreach($interviews as $interview)
                                          <div class="bg-gray-50 p-3 rounded border @if($interview->is_completed) border-green-200 @else border-gray-200 @endif">
                                              <div class="flex justify-between mb-2">
                                                  <h4 class="font-semibold">{{ $interview->type }} Interview</h4>
                                                  @if($interview->is_completed)
                                                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                          {{ __('Completed') }}
                                                      </span>
                                                  @else
                                                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                          {{ __('Scheduled') }}
                                                      </span>
                                                  @endif
                                              </div>
                                              <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                  <div>
                                                      <span class="font-medium">{{ __('Date & Time') }}:</span>
                                                      <span>{{ \Carbon\Carbon::parse($interview->scheduled_at)->format('M d, Y h:i A') }}</span>
                                                  </div>
                                                  <div>
                                                      <span class="font-medium">{{ __('Location/Link') }}:</span>
                                                      <span>{{ $interview->location }}</span>
                                                  </div>
                                              </div>
                                              <div class="mt-2">
                                                  <span class="font-medium">{{ __('Notes') }}:</span>
                                                  <p>{{ $interview->notes }}</p>
                                              </div>
                                              <div class="mt-2 flex space-x-2">
                                                  <a href="{{ route('employer.interviews.edit', $interview->id) }}" class="text-blue-600 hover:text-blue-900">
                                                      {{ __('Edit') }}
                                                  </a>
                                                  @if(!$interview->is_completed)
                                                      <form action="{{ route('employer.interviews.complete', $interview->id) }}" method="POST" class="inline">
                                                          @csrf
                                                          @method('PUT')
                                                          <button type="submit" class="text-green-600 hover:text-green-900">
                                                              {{ __('Mark as Completed') }}
                                                          </button>
                                                      </form>
                                                  @endif
                                              </div>
                                          </div>
                                      @endforeach
                                  </div>
                              @else
                                  <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded text-center">
                                      {{ __('No interviews scheduled yet.') }}
                                  </div>
                              @endif
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>