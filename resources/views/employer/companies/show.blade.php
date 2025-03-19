<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Company Profile') }}
          </h2>
          <a href="{{ route('employer.companies.edit', $company->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
              {{ __('Edit Profile') }}
          </a>
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <div class="mb-8 flex flex-col md:flex-row">
                      <div class="md:w-1/3 mb-6 md:mb-0 md:pr-6">
                          <div class="bg-gray-100 p-4 rounded-lg h-64 flex items-center justify-center">
                              @if ($company->logo)
                                  <img src="{{ Storage::url($company->logo) }}" alt="{{ $company->name }}" class="max-h-full max-w-full object-contain">
                              @else
                                  <div class="text-gray-400 text-center">
                                      <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                      </svg>
                                      <p class="mt-2">No Logo</p>
                                  </div>
                              @endif
                          </div>
                      </div>
                      <div class="md:w-2/3">
                          <h1 class="text-2xl font-bold mb-2">{{ $company->name }}</h1>
                          
                          <div class="mb-4 flex flex-wrap gap-2">
                              <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                  {{ $company->industry }}
                              </div>
                              <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                  {{ $company->size }} employees
                              </div>
                              @if($company->founded_year)
                              <div class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                  Founded {{ $company->founded_year }}
                              </div>
                              @endif
                          </div>
                          
                          <div class="mb-4">
                              <div class="flex items-center text-gray-600 mb-2">
                                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                  </svg>
                                  {{ $company->location }}
                              </div>
                              
                              @if($company->website)
                              <div class="flex items-center text-gray-600">
                                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                  </svg>
                                  <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $company->website }}</a>
                              </div>
                              @endif
                          </div>
                      </div>
                  </div>
                  
                  <div class="border-t pt-6">
                      <h2 class="text-xl font-semibold mb-4">About {{ $company->name }}</h2>
                      <div class="prose max-w-none">
                          {{ $company->description }}
                      </div>
                  </div>
                  
                  <div class="mt-8 flex justify-between items-center">
                      <a href="{{ route('employer.companies.index') }}" class="text-gray-600 hover:text-gray-900">
                          <span class="flex items-center">
                              <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                              </svg>
                              Back to Companies
                          </span>
                      </a>
                      
                      <div class="flex space-x-2">
                          <a href="{{ route('employer.companies.edit', $company->id) }}" class="px-4 py-2 bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200 transition">
                              Edit
                          </a>
                          <form action="{{ route('employer.companies.destroy', $company->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this company?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="px-4 py-2 bg-red-100 text-red-800 rounded-md hover:bg-red-200 transition">
                                  Delete
                              </button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>