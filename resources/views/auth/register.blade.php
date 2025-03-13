<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="flex justify-center">
            <h1 class="text-3xl font-semibold text-gray-800 tracking-wide mb-4">Sign-up</h1>
        </div>
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-700">Or Sign up With</h3>
            <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
                <!-- Login with GitHub -->
                <a href="{{ url('/auth/github/redirect') }}"
                    class="bg-gray-900 text-white px-6 py-3 rounded-md flex items-center justify-center space-x-2 hover:bg-gray-800 transition-colors">
                    <svg class="h-5 w-5" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12 0a12 12 0 00-3.8 23.4c.6.1.8-.2.8-.5v-2.1c-3.4.7-4.1-1.6-4.1-1.6-.6-1.5-1.4-1.9-1.4-1.9-1.1-.8.1-.8.1-.8 1.3.1 2 .9 2 .9 1.1 2 2.8 1.4 3.5 1.1.1-.8.4-1.4.8-1.7-2.7-.3-5.5-1.4-5.5-6.2 0-1.4.5-2.5 1.3-3.4-.1-.3-.6-1.5.1-3 0 0 1-.3 3.4 1.3a11.6 11.6 0 016.2 0c2.4-1.6 3.4-1.3 3.4-1.3.7 1.5.3 2.7.1 3 .8.9 1.3 2 1.3 3.4 0 4.8-2.8 5.9-5.5 6.2.5.4.9 1.2.9 2.4v3.5c0 .3.2.6.8.5A12 12 0 0012 0z">
                        </path>
                    </svg>
                    <span>Sign up with GitHub</span>
                </a>

                <!-- Login with Google -->
                <a href="{{ url('/auth/google/redirect') }}"
                    class="bg-gray-900 text-white px-6 py-3 rounded-md flex items-center justify-center space-x-2 hover:bg-gray-800 transition-colors">
                    <svg class="h-5 w-5" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path
                            d="M12.545,10.917v3.418h5.695c-.226,1.564-1.695,2.914-3.545,3.727l2.818,2.182c2.045-1.909,3.227-4.727,3.227-7.909c0-.727-.068-1.432-.182-2.109h-7.013Z" />
                        <path
                            d="M5.636,13.591c-.409-1.227-.636-2.545-.636-3.909s.227-2.682.636-3.909L2.818,3.591C1.136,6.045,0,8.909,0,12s1.136,5.955,2.818,8.409l2.818-2.818Z" />
                        <path
                            d="M12.545,5.455c1.591,0,3.045.682,4.091,1.773l2.818-2.818C17.5,2.682,15.045,1.636,12.545,1.636c-3.409,0-6.364,1.818-8.045,4.545l2.818,2.818c.818-2.045,2.727-3.545,4.227-3.545Z" />
                    </svg>
                    <span>Sign up with Google</span>
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>