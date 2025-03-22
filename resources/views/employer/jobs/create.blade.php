<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Post New Job') }}
          </h2>
          <a href="{{ route('employer.jobs.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
              {{ __('← Back to Jobs') }}
          </a>
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <form method="POST" action="{{ route('employer.jobs.store') }}" class="space-y-6">
                      @csrf

                      <!-- Company Selection -->
                      <div>
                          <x-input-label for="company_id" :value="__('Company')" />
                          <select id="company_id" name="company_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                              <option value="">Select Company</option>
                              @foreach($companies as $company)
                                  <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                      {{ $company->name }}
                                  </option>
                              @endforeach
                          </select>
                          <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
                          @if($companies->isEmpty())
                              <p class="text-sm text-gray-500 mt-2">
                                  No companies found. <a href="{{ route('employer.companies.create') }}" class="text-blue-600 hover:underline">Create a company profile</a> first.
                              </p>
                          @endif
                      </div>

                      <!-- Job Category -->
                      <div>
                          <x-input-label for="category_id" :value="__('Job Category')" />
                          <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                              <option value="">Select Category</option>
                              @foreach($categories as $category)
                                  <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                      {{ $category->name }}
                                  </option>
                              @endforeach
                          </select>
                          <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                      </div>

                      <!-- Job Title -->
                      <div>
                          <x-input-label for="title" :value="__('Job Title')" />
                          <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title') }}" required />
                          <x-input-error :messages="$errors->get('title')" class="mt-2" />
                      </div>

                      <!-- Job Location -->
                      <div>
                          <x-input-label for="location" :value="__('Location')" />
                          <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" value="{{ old('location') }}" required />
                          <x-input-error :messages="$errors->get('location')" class="mt-2" />
                      </div>

                      <!-- Work Type -->
                      <div>
                          <x-input-label for="work_type" :value="__('Work Type')" />
                          <select id="work_type" name="work_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                              <option value="">Select Work Type</option>
                              <option value="full-time" {{ old('work_type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                              <option value="part-time" {{ old('work_type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                              <option value="contract" {{ old('work_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                              <option value="freelance" {{ old('work_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                              <option value="internship" {{ old('work_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                              <option value="remote" {{ old('work_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                              <option value="hybrid" {{ old('work_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                          </select>
                          <x-input-error :messages="$errors->get('work_type')" class="mt-2" />
                      </div>

                      <!-- Salary Range -->
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                          <div>
                              <x-input-label for="salary_min" :value="__('Minimum Salary')" />
                              <x-text-input id="salary_min" name="salary_min" type="number" class="mt-1 block w-full" value="{{ old('salary_min') }}" />
                              <x-input-error :messages="$errors->get('salary_min')" class="mt-2" />
                          </div>
                          <div>
                              <x-input-label for="salary_max" :value="__('Maximum Salary')" />
                              <x-text-input id="salary_max" name="salary_max" type="number" class="mt-1 block w-full" value="{{ old('salary_max') }}" />
                              <x-input-error :messages="$errors->get('salary_max')" class="mt-2" />
                          </div>
                      </div>

                      <!-- Application Deadline -->
                      <div>
                          <x-input-label for="application_deadline" :value="__('Application Deadline')" />
                          <x-text-input id="application_deadline" name="application_deadline" type="date" class="mt-1 block w-full" value="{{ old('application_deadline') }}" required />
                          <x-input-error :messages="$errors->get('application_deadline')" class="mt-2" />
                      </div>

                      <!-- Job Description -->
                      <div>
                          <x-input-label for="description" :value="__('Job Description')" />
                          <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description') }}</textarea>
                          <x-input-error :messages="$errors->get('description')" class="mt-2" />
                      </div>

                      <!-- Responsibilities -->
                      <div>
                          <x-input-label for="responsibilities" :value="__('Responsibilities')" />
                          <textarea id="responsibilities" name="responsibilities" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('responsibilities') }}</textarea>
                          <x-input-error :messages="$errors->get('responsibilities')" class="mt-2" />
                      </div>

                      <!-- Requirements -->
                      <div>
                          <x-input-label for="requirements" :value="__('Requirements')" />
                          <textarea id="requirements" name="requirements" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('requirements') }}</textarea>
                          <x-input-error :messages="$errors->get('requirements')" class="mt-2" />
                      </div>

                      <!-- Benefits -->
                      <div>
                          <x-input-label for="benefits" :value="__('Benefits')" />
                          <textarea id="benefits" name="benefits" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('benefits') }}</textarea>
                          <x-input-error :messages="$errors->get('benefits')" class="mt-2" />
                      </div>

                      <!-- Technologies -->
                      <div>
                          <x-input-label :value="__('Technologies')" />
                          <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                              @foreach($technologies as $technology)
                                  <div class="flex items-center">
                                      <input id="tech_{{ $technology->id }}" name="technologies[]" type="checkbox" value="{{ $technology->id }}" 
                                          class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" 
                                          {{ (is_array(old('technologies')) && in_array($technology->id, old('technologies'))) ? 'checked' : '' }}>
                                      <label for="tech_{{ $technology->id }}" class="ml-2 text-sm text-gray-700">{{ $technology->name }}</label>
                                  </div>
                              @endforeach
                          </div>
                          <x-input-error :messages="$errors->get('technologies')" class="mt-2" />
                      </div>

                      <!-- Active Status -->
                      <div class="flex items-center">
                          <input id="is_active" name="is_active" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('is_active') ? 'checked' : '' }}>
                          <label for="is_active" class="ml-2 block text-sm text-gray-900">
                              Publish immediately (subject to approval)
                          </label>
                      </div>

                      <div class="flex items-center justify-end mt-6">
                          <x-primary-button>
                              {{ __('Post Job') }}
                          </x-primary-button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>