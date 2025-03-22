<x-guest-layout>
    <x-slot name="title">Log In to Your Account</x-slot>
    <x-auth-session-status class="mb-4 text-center" :status="session('status')" />
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="font-medium" />
            <x-text-input id="email" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="font-medium" />
            <x-text-input id="password" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
            @endif
        </div>
        <!-- Submit -->
        <div>
            <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-700">
                {{ __('Log In') }}
            </x-primary-button>
            <p class="mt-2 text-center text-sm text-gray-600">
                Don’t have an account? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Sign up</a>
            </p>
        </div>
    </form>
</x-guest-layout>