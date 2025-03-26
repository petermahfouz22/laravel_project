<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Edit Profile') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
              <div class="max-w-xl">
                  <section>
                      <header>
                          <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                              {{ __('Personal Information') }}
                          </h2>
                          <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                              {{ __('Update your profile\'s personal details.') }}
                          </p>
                      </header>

                      <form method="POST" action="{{ route('candidate.profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                          @csrf

                          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                              {{-- Basic Information --}}
                              <div class="space-y-4">
                                  <div>
                                      <x-input-label for="name" :value="__('Full Name')" />
                                      <x-text-input id="name" name="name" type="text" 
                                          class="mt-1 block w-full" 
                                          :value="old('name', $user->name)" 
                                          required 
                                          autofocus 
                                          autocomplete="name" 
                                      />
                                      <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                  </div>

                                  <div>
                                      <x-input-label for="email" :value="__('Email Address')" />
                                      <x-text-input id="email" name="email" type="email" 
                                          class="mt-1 block w-full" 
                                          :value="old('email', $user->email)" 
                                          required 
                                          autocomplete="email" 
                                      />
                                      <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                  </div>

                                  <div>
                                      <x-input-label for="phone" :value="__('Phone Number')" />
                                      <x-text-input id="phone" name="phone" type="tel" 
                                          class="mt-1 block w-full" 
                                          :value="old('phone', $user->profile->phone ?? '')" 
                                          autocomplete="tel" 
                                      />
                                      <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                  </div>
                              </div>

                              {{-- Professional Details --}}
                              <div class="space-y-4">
                                  <div>
                                      <x-input-label for="location" :value="__('Location')" />
                                      <x-text-input id="location" name="location" type="text" 
                                          class="mt-1 block w-full" 
                                          :value="old('location', $user->profile->location ?? '')" 
                                          autocomplete="address-level2" 
                                      />
                                      <x-input-error class="mt-2" :messages="$errors->get('location')" />
                                  </div>

                                  <div>
                                      <x-input-label for="linkedin_url" :value="__('LinkedIn Profile')" />
                                      <x-text-input id="linkedin_url" name="linkedin_url" type="url" 
                                          class="mt-1 block w-full" 
                                          :value="old('linkedin_url', $user->profile->linkedin_url ?? '')" 
                                          placeholder="https://www.linkedin.com/in/yourprofile" 
                                      />
                                      <x-input-error class="mt-2" :messages="$errors->get('linkedin_url')" />
                                  </div>

                                  <div>
                                      <x-input-label for="website" :value="__('Personal Website')" />
                                      <x-text-input id="website" name="website" type="url" 
                                          class="mt-1 block w-full" 
                                          :value="old('website', $user->profile->website ?? '')" 
                                          placeholder="https://www.yourportfolio.com" 
                                      />
                                      <x-input-error class="mt-2" :messages="$errors->get('website')" />
                                  </div>
                              </div>
                          </div>

                          {{-- Bio Section --}}
                          <div class="mt-6">
                              <x-input-label for="bio" :value="__('Professional Bio')" />
                              <textarea id="bio" name="bio" 
                                  class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" 
                                  rows="4" 
                                  placeholder="{{ __('Tell us about your professional journey, skills, and aspirations.') }}"
                              >{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                              <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                          </div>

                          {{-- Profile Image Upload --}}
                          <div class="mt-6">
                              <x-input-label for="profile_image" :value="__('Profile Picture')" />
                              <input id="profile_image" name="profile_image" type="file" 
                                  class="mt-1 block w-full text-sm text-gray-500 
                                  file:mr-4 file:py-2 file:px-4 
                                  file:rounded-full file:border-0 
                                  file:text-sm file:font-semibold 
                                  file:bg-blue-50 file:text-blue-700 
                                  hover:file:bg-blue-100" 
                                  accept="image/*" 
                              />
                              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                  {{ __('PNG, JPG, or WEBP (max 5MB)') }}
                              </p>
                              <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
                          </div>

                          <div class="flex items-center gap-4 mt-6">
                              <x-primary-button>{{ __('Save Profile') }}</x-primary-button>

                              @if (session('status') === 'profile-updated')
                                  <p
                                      x-data="{ show: true }"
                                      x-show="show"
                                      x-transition
                                      x-init="setTimeout(() => show = false, 2000)"
                                      class="text-sm text-gray-600 dark:text-gray-400"
                                  >{{ __('Saved.') }}</p>
                              @endif
                          </div>
                      </form>
                  </section>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>