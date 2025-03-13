@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo and Header -->
        <div>
            <img class="mx-auto h-20 w-auto" src="{{ asset('images/logo.png') }}" alt="JobBoard">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Create Your Account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Start your journey with us
            </p>
        </div>

        <!-- Form -->
        <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="rounded-lg shadow-sm space-y-4">
                <!-- Name -->
                <div>
                    <label for="name" class="sr-only">Full Name</label>
                    <input id="name" name="name" type="text" autocomplete="name" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300
                           placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500
                           focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Full Name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300
                           placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500
                           focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Email address">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300
                           placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500
                           focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="sr-only">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" 
                           autocomplete="new-password" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300
                           placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500
                           focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Confirm Password">
                </div>

                <!-- Role Selection -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Register as:
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative">
                            <input class="peer hidden" id="employer" type="radio" name="role" value="employer">
                            <label for="employer" 
                                   class="block cursor-pointer text-center py-2 px-4 border border-gray-300 
                                   rounded-lg hover:border-indigo-500 peer-checked:border-indigo-600 
                                   peer-checked:bg-indigo-50 transition-colors">
                                Employer
                            </label>
                        </div>
                        <div class="relative">
                            <input class="peer hidden" id="candidate" type="radio" name="role" value="candidate" checked>
                            <label for="candidate" 
                                   class="block cursor-pointer text-center py-2 px-4 border border-gray-300 
                                   rounded-lg hover:border-indigo-500 peer-checked:border-indigo-600 
                                   peer-checked:bg-indigo-50 transition-colors">
                                Candidate
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm
                    font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                    focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                Create Account
            </button>
            <a href="/auth/redirect" class="flex items-center justify-center bg-gray-800 text-white py-2 px-4 rounded-lg hover:bg-gray-900">
    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.024 2.87.782.088-.608.342-1.024.624-1.304-2.18-.248-4.474-1.08-4.474-4.813 0-1.062.38-1.931 1.029-2.617-.103-.253-.446-1.272.098-2.643 0 0 .84-.268 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.026 2.747-1.026.546 1.371.203 2.398.1 2.643.648.686 1.028 1.555 1.028 2.617 0 3.741-2.293 4.562-4.478 4.813.352.304.664.913.664 1.846 0 1.334-.012 2.41-.012 2.737 0 .267.18.577.688.48C21.135 20.197 24 16.442 24 12.017 24 6.484 19.523 2 12 2z" clip-rule="evenodd"/>
    </svg>
    Login with GitHub
</a>
<!-- Google Login Button -->
<a href="/auth/google/redirect" class="flex items-center justify-center bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 mt-2">
    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
        <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z" fill="#4285F4"/>
        <path d="M12.545,10.239l9.426,0.013c0.823,3.898-1.03,11.748-9.426,11.748c-5.524,0-10.002-4.477-10.002-10s4.478-10,10.002-10c2.594,0,4.958,0.988,6.735,2.607l-2.814,2.814c-1.055-0.904-2.423-1.453-3.921-1.453c-3.332,0-6.033,2.701-6.033,6.032s2.701,6.032,6.033,6.032c2.798,0,4.733-1.657,5.445-3.972h-5.445V10.239z" fill="#34A853"/>
        <path d="M19.281,11.761h-6.736v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L19.281,11.761z" fill="#FBBC05"/>
        <path d="M12.545,18.032c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748l-9.426-0.013v3.821h5.445C17.198,16.375,15.343,18.032,12.545,18.032z" fill="#EA4335"/>
    </svg>
    Login with Google
</a>

<!-- Facebook Login Button -->
<a href="/auth/facebook/redirect" class="flex items-center justify-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 mt-2">
    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.73 0 1.323-.593 1.323-1.325V1.325C24 .593 23.407 0 22.675 0z"></path>
    </svg>
    Login with Facebook
</a>

            <!-- Login Link -->
            <div class="text-center text-sm">
                <span class="text-gray-600">Already have an account? </span>
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Sign in
                </a>
            </div>
        </form>
    </div>
</div>
@endsection