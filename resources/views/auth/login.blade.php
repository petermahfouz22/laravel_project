<x-guest-layout>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-8">
      <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden">
          <div class="p-8">
              <div class="text-center mb-6">
                  <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ __('Log in to your account') }}</h2>
                  <p class="text-gray-600">{{ __('Welcome back! Please enter your details') }}</p>
              </div>

              <x-auth-session-status class="mb-4" :status="session('status')" />
              
              @if (session('social_login'))
                  <div class="mb-4 text-center text-sm text-red-600">
                      {{ session('social_login') }}
                  </div>
              @endif

              <form method="POST" action="{{ route('login') }}" class="space-y-4">
                  @csrf
                  <!-- Email -->
                  <div>
                      <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-1" />
                      <x-text-input 
                          id="email" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
                          autofocus 
                          autocomplete="username"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                      />
                      <x-input-error :messages="$errors->get('email')" class="mt-2" />
                  </div>

                  <!-- Password -->
                  <div>
                      <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 mb-1" />
                      <x-text-input 
                          id="password" 
                          type="password" 
                          name="password" 
                          required 
                          autocomplete="current-password"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                      />
                      <x-input-error :messages="$errors->get('password')" class="mt-2" />
                  </div>

                  <!-- Remember Me & Forgot Password -->
                  <div class="flex items-center justify-between">
                      <div class="flex items-center">
                          <input 
                              id="remember_me" 
                              type="checkbox" 
                              name="remember" 
                              class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                          >
                          <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                              {{ __('Remember me') }}
                          </label>
                      </div>

                      @if (Route::has('password.request'))
                          <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                              {{ __('Forgot password?') }}
                          </a>
                      @endif
                  </div>

                  <!-- Submit Button -->
                  <div>
                      <x-primary-button class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                          {{ __('Log In') }}
                      </x-primary-button>
                  </div>
              </form>

              <!-- Social Login -->
              <div class="mt-6">
                  <div class="relative">
                      <div class="absolute inset-0 flex items-center">
                          <div class="w-full border-t border-gray-300"></div>
                      </div>
                      <div class="relative flex justify-center text-sm">
                          <span class="px-2 bg-white text-gray-500">{{ __('Or continue with') }}</span>
                      </div>
                  </div>

            
              </div>

              <!-- Register Link -->
              <div class="mt-6 text-center">
                  <p class="text-sm text-gray-600">
                      {{ __("Don't have an account?") }}
                      <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:underline">
                          {{ __('Sign up') }}
                      </a>
                  </p>
              </div>
          </div>
      </div>
  </div>
</x-guest-layout>