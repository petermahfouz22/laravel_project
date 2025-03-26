<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                            {{ __('Manage Resumes') }}
                        </h2>
                        <button x-data x-on:click="$dispatch('open-resume-modal')" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            {{ __('Upload New Resume') }}
                        </button>
                    </div>

                    @if (session('status'))
                        <div class="bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-200 p-4 mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($user->resumes->isEmpty())
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('No resumes uploaded yet. Upload your first resume!') }}
                            </p>
                        </div>
                    @else
                        <!-- Existing resume list code remains the same -->
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                          @foreach ($user->resumes as $resume)
                          <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md p-6 relative">
                              <div class="flex justify-between items-start">
                                  <div>
                                      <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                          {{ $resume->title }}
                                      </h3>
                                      <p class="text-sm text-gray-500 dark:text-gray-400">
                                          {{ $resume->created_at->diffForHumans() }}
                                      </p>
                                  </div>
                                  @if ($resume->is_default)
                                      <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                          Default
                                      </span>
                                  @endif
                              </div>

                              {{-- <div class="mt-4  space-y-2">
                                  <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                      </svg>
                                      {{ basename($resume->file_path) }}
                                  </div>
                                  <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                      </svg>
                                      {{ $resume->type ?? 'General' }} Resume
                                  </div>
                              </div> --}}

                              <div class="mt-4 flex justify-between items-center">
                                  <a href="{{ route('candidate.resume.download', $resume) }}" 
                                     class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition">
                                      Download
                                  </a>
                                  <div class="flex space-x-2">
                                      @if (!$resume->is_default)
                                          <form method="POST" action="{{ route('candidate.resume.set-default', $resume) }}">
                                              @csrf
                                              @method('PUT')
                                              <button type="submit" class="text-green-600 hover:text-green-800 text-sm">
                                                  Set as Default
                                              </button>
                                          </form>
                                      @endif
                                      <form method="POST" action="{{ route('candidate.resume.delete', $resume) }}">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                              Delete
                                          </button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Resume Upload Modal -->
    <div 
        x-data="{ open: false }" 
        x-on:open-resume-modal.window="open = true"
        x-show="open" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
    >
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div 
                x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity"
                aria-hidden="true"
            >
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal content -->
            <div 
                x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            >
            <h3 class="text-2xl font-bold">Upload Resume</h3>
            <form method="POST" action="{{ route('candidate.resume.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Resume Title *</label>
                    <input id="title" name="title" type="text" value="{{ old('title') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    @error('title')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- File Input -->
                <div class="mb-4">
                    <label for="file_path" class="block text-sm font-medium text-gray-700">Resume *</label>
                    <input id="file_path" name="file_path" type="file" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    @error('file_path')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Is Default -->
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_default" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">Set as default resume</span>
                    </label>
                    @error('is_default')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md">Upload Resume</button>
            </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>