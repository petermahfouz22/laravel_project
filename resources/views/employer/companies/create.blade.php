<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Create Company Profile') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <form method="POST" action="{{ route('employer.companies.store') }}" enctype="multipart/form-data">
                      @csrf

                      <!-- Company Name -->
                      <div class="mb-4">
                          <x-input-label for="name" :value="__('Company Name')" />
                          <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                          <x-input-error :messages="$errors->get('name')" class="mt-2" />
                      </div>

                      <!-- Company Logo -->
                      <div class="mb-4">
                          <x-input-label for="logo" :value="__('Company Logo')" />
                          <input id="logo" type="file" name="logo" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" accept="image/*">
                          <p class="mt-1 text-sm text-gray-500">Recommended size: 400x400px (JPG, PNG)</p>
                          <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                      </div>

                      <!-- Company Description -->
                      <div class="mb-4">
                          <x-input-label for="description" :value="__('Company Description')" />
                          <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('description') }}</textarea>
                          <x-input-error :messages="$errors->get('description')" class="mt-2" />
                      </div>

                      <!-- Company Website -->
                      <div class="mb-4">
                          <x-input-label for="website" :value="__('Website')" />
                          <x-text-input id="website" class="block mt-1 w-full" type="url" name="website" :value="old('website')" placeholder="https://example.com" />
                          <x-input-error :messages="$errors->get('website')" class="mt-2" />
                      </div>

                      <!-- Company Location -->
                      <div class="mb-4">
                          <x-input-label for="location" :value="__('Location')" />
                          <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                          <x-input-error :messages="$errors->get('location')" class="mt-2" />
                      </div>

                      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                          <!-- Company Industry -->
                          <div class="mb-4">
                              <x-input-label for="industry" :value="__('Industry')" />
                              <select id="industry" name="industry" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                  <option value="">Select Industry</option>
                                  <option value="Technology">Technology</option>
                                  <option value="Finance">Finance</option>
                                  <option value="Healthcare">Healthcare</option>
                                  <option value="Education">Education</option>
                                  <option value="Manufacturing">Manufacturing</option>
                                  <option value="Retail">Retail</option>
                                  <option value="Hospitality">Hospitality</option>
                                  <option value="Construction">Construction</option>
                                  <option value="Transportation">Transportation</option>
                                  <option value="Other">Other</option>
                              </select>
                              <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                          </div>

                          <!-- Company Size -->
                          <div class="mb-4">
                              <x-input-label for="size" :value="__('Company Size')" />
                              <select id="size" name="size" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                  <option value="">Select Size</option>
                                  <option value="1-10">1-10 employees</option>
                                  <option value="11-50">11-50 employees</option>
                                  <option value="51-200">51-200 employees</option>
                                  <option value="201-500">201-500 employees</option>
                                  <option value="501-1000">501-1000 employees</option>
                                  <option value="1000+">1000+ employees</option>
                              </select>
                              <x-input-error :messages="$errors->get('size')" class="mt-2" />
                          </div>
                      </div>

                      <!-- Founded Year -->
                      <div class="mb-6">
                          <x-input-label for="founded_year" :value="__('Founded Year')" />
                          <x-text-input id="founded_year" class="block mt-1 w-full" type="number" name="founded_year" :value="old('founded_year')" min="1800" max="{{ date('Y') }}" />
                          <x-input-error :messages="$errors->get('founded_year')" class="mt-2" />
                      </div>

                      <div class="flex items-center justify-end mt-4">
                          <a href="{{ route('employer.companies.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">
                              {{ __('Cancel') }}
                          </a>
                          <x-primary-button>
                              {{ __('Create Company') }}
                          </x-primary-button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>