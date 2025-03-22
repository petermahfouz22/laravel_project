<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Company Profiles') }}
          </h2>
          <a href="{{ route('employer.companies.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
              {{ __('Add New Company') }}
          </a>
          <a href="{{ route('employer.dashboard') }}" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-blue-700 transition">
            {{ __('My DashBoard') }}
        </a>
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          @if (session('success'))
              <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                  <span class="block sm:inline">{{ session('success') }}</span>
              </div>
          @endif

          @if($companies->count() > 0)
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="p-6 bg-white border-b border-gray-200">
                      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                          @foreach ($companies as $company)
                              <div class="bg-white rounded-lg shadow overflow-hidden">
                                  <div class="h-48 bg-gray-100 flex items-center justify-center">
                                      @if ($company->logo)
                                          <img src="{{ Storage::url($company->logo) }}" alt="{{ $company->name }}" class="max-h-full max-w-full object-contain p-4">
                                      @else
                                          <div class="text-gray-400 text-center">
                                              <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                              </svg>
                                              <p class="mt-2">No Logo</p>
                                          </div>
                                      @endif
                                  </div>
                                  <div class="p-4">
                                      <h3 class="font-semibold text-lg mb-2">{{ $company->name }}</h3>
                                      <p class="text-gray-600 text-sm mb-3 truncate">{{ $company->location }}</p>
                                      <p class="text-gray-600 text-sm mb-3">{{ $company->industry }}</p>
                                      <div class="flex flex-wrap gap-2 mt-4">
                                          <a href="{{ route('employer.companies.show', $company->id) }}" class="px-3 py-1 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200 transition">
                                              View
                                          </a>
                                          <a href="{{ route('employer.companies.edit', $company->id) }}" class="px-3 py-1 bg-gray-100 text-gray-800 rounded-md text-sm hover:bg-gray-200 transition">
                                              Edit
                                          </a>
                                          <form action="{{ route('employer.companies.destroy', $company->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this company?');">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" class="px-3 py-1 bg-red-100 text-red-800 rounded-md text-sm hover:bg-red-200 transition">
                                                  Delete
                                              </button>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          @endforeach
                      </div>
                  </div>
              </div>
          @else
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="p-6 bg-white border-b border-gray-200">
                      <div class="text-center py-8">
                          <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                          </svg>
                          <h3 class="text-lg font-medium text-gray-900 mb-2">No companies found</h3>
                          <p class="text-gray-500 mb-6">Get started by creating your first company profile.</p>
                          <a href="{{ route('employer.companies.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                              {{ __('Create Company Profile') }}
                          </a>
                      </div>
                  </div>
              </div>
          @endif
      </div>
  </div>
</x-app-layout>