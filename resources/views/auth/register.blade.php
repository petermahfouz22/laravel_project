<x-guest-layout>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
          <!-- Header -->
          <div>
              <h2 class="text-center text-3xl font-bold text-gray-900">Sign Up as {{ ucfirst($role) }}</h2>
              <p class="mt-2 text-center text-sm text-gray-600">
                  Create your account to get started
              </p>
          </div>

          <!-- Form -->
          <form method="POST" action="{{ route('register') }}" class="space-y-6">
              @csrf

              <!-- Hidden Role Input -->
              <input type="hidden" name="role" value="{{ $role }}">

              <!-- Name -->
              <div>
                  <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                  <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                         class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                         placeholder="John Doe">
                  @error('name')
                      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>

              <!-- Email -->
              <div>
                  <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                  <input id="email" name="email" type="email" value="{{ old('email') }}" required
                         class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                         placeholder="you@example.com">
                  @error('email')
                      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>

              <!-- Password -->
              <div>
                  <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                  <input id="password" name="password" type="password" required
                         class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                         placeholder="••••••••">
                  @error('password')
                      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>

              <!-- Password Confirmation -->
              <div>
                  <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                  <input id="password_confirmation" name="password_confirmation" type="password" required
                         class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                         placeholder="••••••••">
                  @error('password_confirmation')
                      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>

              <!-- Submit Button -->
              <div>
                  <button type="submit"
                          class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      Register
                  </button>
              </div>
          </form>

          <!-- Socialite Buttons -->
          <div class="mt-6">
              <div class="relative">
                  <div class="absolute inset-0 flex items-center">
                      <div class="w-full border-t border-gray-300"></div>
                  </div>
                  <div class="relative flex justify-center text-sm">
                      <span class="px-2 bg-white text-gray-500">Or sign up with</span>
                  </div>
              </div>
              <div class="mt-6 space-y-3">
                  <!-- GitHub -->
                  <a href="{{ route('socialite.redirect', ['provider' => 'github', 'role' => $role]) }}"
                     class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      <svg class="h-5 w-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                          <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12 0a12 12 0 00-3.8 23.4c.6.1.8-.2.8-.5v-2.1c-3.4.7-4.1-1.6-4.1-1.6-.6-1.5-1.4-1.9-1.4-1.9-1.1-.8.1-.8.1-.8 1.3.1 2 .9 2 .9 1.1 2 2.8 1.4 3.5 1.1.1-.8.4-1.4.8-1.7-2.7-.3-5.5-1.4-5.5-6.2 0-1.4.5-2.5 1.3-3.4-.1-.3-.6-1.5.1-3 0 0 1-.3 3.4 1.3a11.6 11.6 0 016.2 0c2.4-1.6 3.4-1.3 3.4-1.3.7 1.5.3 2.7.1 3 .8.9 1.3 2 1.3 3.4 0 4.8-2.8 5.9-5.5 6.2.5.4.9 1.2.9 2.4v3.5c0 .3.2.6.8.5A12 12 0 0012 0z">
                          </path>
                      </svg>
                      GitHub
                  </a>
                  <!-- Google -->
                  <a href="{{ route('socialite.redirect', ['provider' => 'google', 'role' => $role]) }}"
                     class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                          <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                          <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                          <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                          <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                          <path d="M1 1h22v22H1z" fill="none"/>
                      </svg>
                      Google
                  </a>
                  <!-- Facebook -->
                  <a href="{{ route('socialite.redirect', ['provider' => 'facebook', 'role' => $role]) }}"
                     class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      <svg class="h-5 w-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                          <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                      </svg>
                      Facebook
                  </a>
              </div>
          </div>

          <!-- Login Link -->
          <p class="mt-6 text-center text-sm text-gray-600">
              Already have an account?
              <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Log in</a>
          </p>
      </div>
  </div>
</x-guest-layout>