<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Upload Resume') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                  <!-- Success Message -->
                  @if (session('status'))
                      <div class="mb-4 text-green-600">
                          {{ session('status') }}
                      </div>
                  @endif

                  <!-- Form -->
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

                  <!-- Display Resumes -->
                  <h3 class="text-2xl font-bold mt-6">Your Resumes</h3>
                  @if ($user->resumes->isEmpty())
                      <p class="mt-2 text-gray-600">No resumes uploaded yet.</p>
                  @else
                      <ul class="mt-4 space-y-4">
                          @foreach ($user->resumes as $resume)
                              <li class="border-b pb-4">
                                  <p class="text-gray-600">Title: {{ $resume->title }}</p>
                                  <p class="text-gray-600">File: {{ basename($resume->path) }}</p>
                                  <p class="text-sm text-gray-500">Uploaded on: {{ $resume->created_at->format('M d, Y') }}</p>
                                  @if ($resume->is_default)
                                      <span class="text-green-600">Default</span>
                                  @endif
                              </li>
                          @endforeach
                      </ul>
                  @endif
              </div>
          </div>
      </div>
  </div>
</x-app-layout>