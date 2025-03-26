<x-app-layout>
  <div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
          {{-- Status Message --}}
          @if (session('status'))
              <div class="bg-blue-100 dark:bg-blue-900 border-l-4 border-blue-500 dark:border-blue-400 text-blue-700 dark:text-blue-200 p-4 mb-6" role="alert">
                  {{ session('status') }}
              </div>
          @endif

          <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-lg overflow-hidden">
              {{-- Profile Header --}}
              <div class="bg-gradient-to-r from-blue-700 to-blue-900 p-6">
                  <div class="flex items-center space-x-6">
                      <div class="w-24 h-24 flex-shrink-0">
                          <img 
                              src="{{ $user->profile->profile_image ? Storage::url($user->profile->profile_image) : '/default-avatar.png' }}" 
                              alt="{{ $user->name }}'s profile picture" 
                              class="w-24 h-24 rounded-full object-cover border-4 border-white/20"
                          >
                      </div>
                      <div>
                          <h2 class="text-3xl font-bold text-white mb-2">{{ $user->name }}</h2>
                          <p class="text-blue-100 text-sm">{{ $user->email }}</p>
                      </div>
                  </div>
              </div>

              {{-- Profile Content --}}
              <div class="p-6">
                  <div class="grid md:grid-cols-3 gap-8">
                      {{-- Personal Information --}}
                      <div>
                          <h3 class="text-xl font-semibold text-blue-900 dark:text-blue-200 mb-4 border-b pb-2">
                              <i class="fas fa-user mr-2"></i>Personal Information
                          </h3>
                          <div class="space-y-3 text-gray-700 dark:text-gray-300">
                              <div>
                                  <span class="font-medium text-blue-700 dark:text-blue-300">Full Name:</span>
                                  {{ $user->name }}
                              </div>
                              <div>
                                  <span class="font-medium text-blue-700 dark:text-blue-300">Email:</span>
                                  {{ $user->email }}
                              </div>
                              
                              @if($user->profile)
                                  @if($user->profile->phone)
                                      <div>
                                          <span class="font-medium text-blue-700 dark:text-blue-300">Phone:</span>
                                          {{ $user->profile->phone }}
                                      </div>
                                  @endif

                                  @if($user->profile->location)
                                      <div>
                                          <span class="font-medium text-blue-700 dark:text-blue-300">Location:</span>
                                          {{ $user->profile->location }}
                                      </div>
                                  @endif
                              @endif
                          </div>
                      </div>

                      {{-- Professional Details --}}
                      <div>
                          <h3 class="text-xl font-semibold text-blue-900 dark:text-blue-200 mb-4 border-b pb-2">
                              <i class="fas fa-briefcase mr-2"></i>Professional Profile
                          </h3>
                          <div class="space-y-3 text-gray-700 dark:text-gray-300">
                              @if($user->profile)
                                  @if($user->profile->linkedin_url)
                                      <div>
                                          <span class="font-medium text-blue-700 dark:text-blue-300">LinkedIn:</span>
                                          <a href="{{ $user->profile->linkedin_url }}" target="_blank" 
                                             class="text-blue-600 dark:text-blue-400 hover:underline">
                                              View Profile
                                          </a>
                                      </div>
                                  @endif

                                  @if($user->profile->website)
                                      <div>
                                          <span class="font-medium text-blue-700 dark:text-blue-300">Personal Website:</span>
                                          <a href="{{ $user->profile->website }}" target="_blank" 
                                             class="text-blue-600 dark:text-blue-400 hover:underline">
                                              Visit Website
                                          </a>
                                      </div>
                                  @endif

                                  @if($user->profile->bio)
                                      <div>
                                          <span class="font-medium text-blue-700 dark:text-blue-300">Professional Bio:</span>
                                          <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                              {{ Str::limit($user->profile->bio, 150) }}
                                          </p>
                                      </div>
                                  @endif
                              @endif
                          </div>
                      </div>

                      {{-- Document Management --}}
                      <div>
                          <h3 class="text-xl font-semibold text-blue-900 dark:text-blue-200 mb-4 border-b pb-2">
                              <i class="fas fa-file-alt mr-2"></i>Document Management
                          </h3>
                          <div class="space-y-4">
                              <div>
                                  <span class="font-medium text-blue-700 dark:text-blue-300">Resumes:</span>
                                  <span class="text-gray-700 dark:text-gray-300">
                                      {{ $user->resumes->count() }} uploaded
                                  </span>
                              </div>
{{-- 
                              @if($user->resumes->count() > 0)
                                  <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-md">
                                      <h4 class="text-blue-800 dark:text-blue-200 font-semibold mb-2">Recent Resumes</h4>
                                      @foreach($user->resumes->take(2) as $resume)
                                          <div class="flex justify-between items-center mb-2 last:mb-0">
                                              <span class="text-gray-600 dark:text-gray-300 text-sm">
                                                  {{ Str::limit(basename($resume->path), 20) }}
                                              </span>
                                              <a href="{{ asset('storage/' . $resume->path) }}" 
                                                 target="_blank" 
                                                 class="text-blue-600 dark:text-blue-400 hover:text-blue-800 transition duration-200">
                                                  View
                                              </a>
                                          </div>
                                      @endforeach
                                  </div>
                              @endif --}}
                          </div>
                      </div>
                  </div>

                  {{-- Action Buttons --}}
                  <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                      <div class="space-x-4">
                          <a href="{{ route('candidate.profile.edit') }}" 
                             class="inline-block bg-blue-600 text-white px-5 py-2.5 rounded-md hover:bg-blue-700 transition duration-300 shadow-md">
                              <i class="fas fa-edit mr-2"></i>Edit Profile
                          </a>
                          <a href="{{ route('candidate.profile.resumes') }}" 
                             class="inline-block text-blue-600 dark:text-blue-400 hover:text-blue-800 transition duration-200">
                              <i class="fas fa-file-upload mr-2"></i>Manage Resumes
                          </a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>