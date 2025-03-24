<x-guest-layout>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
          <!-- Debug Message -->
          <div class="text-center text-green-600">
              This is the Role Selection Page
          </div>
          <!-- Header -->
          <div>
              <h2 class="text-center text-3xl font-bold text-gray-900">Sign Up - Choose Your Role</h2>
              <p class="mt-2 text-center text-sm text-gray-600">
                  Are you a candidate looking for a job, or an employer hiring talent?
              </p>
          </div>

          <!-- Role Selection -->
          <div class="mt-6 space-y-4">
              <a href="{{ route('register.form', ['role' => 'candidate']) }}"
                 class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  <svg class="h-6 w-6 mr-2 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  I am a Candidate
              </a>
              <a href="{{ route('register.form', ['role' => 'employer']) }}"
                 class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  <svg class="h-6 w-6 mr-2 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a2 2 0 012-2h2a2 2 0 012 2v5m-4 0h4" />
                  </svg>
                  I am an Employer
              </a>
          </div>

          <!-- Login Link -->
          <p class="mt-6 text-center text-sm text-gray-600">
              Already have an account?
              <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Log in</a>
          </p>
      </div>
  </div>
</x-guest-layout>