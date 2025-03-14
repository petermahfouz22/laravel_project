@extends('layouts.guest_main')

@section('content')
<x-guest-layout>
  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <form method="POST" action="https://api.web3forms.com/submit">

    <input type="hidden" name="access_key" value="eec49e08-c987-440e-841d-a3cde76cd0ca">
      <div class="flex justify-center">
          <h1 class="text-3xl font-semibold text-gray-800 tracking-wide mb-4">contact us</h1>
      </div>
      <!-- Email Address -->
      <div>
          <x-input-label for="email" :value="__('Email')" />
          <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
              autofocus autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      <!-- Password -->
      <div>
  <x-input-label for="description" :value="__('Description')" />
  <textarea id="description" name="description" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:ring focus:ring-opacity-50" rows="4" required></textarea>
  <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

      <div class="flex items-center justify-end mt-4">
          @if (Route::has('password.request'))
              <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                  href="{{ route('password.request') }}">
                  {{ __('Forgot your password?') }}
              </a>
          @endif

          <x-primary-button class="ms-3">
              {{ __('Submit') }}
          </x-primary-button>
      </div>
  </form>
</x-guest-layout>
@endsection