@extends('layouts.guest')

@section('content')
    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="https://api.web3forms.com/submit">
        <input type="hidden" name="access_key" value="eec49e08-c987-440e-841d-a3cde76cd0ca">
        <div class="flex justify-center">
            <h1 class="text-3xl font-semibold text-gray-800 tracking-wide mb-4">contact us</h1>
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:ring focus:ring-opacity-50"
                   type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="mt-4">
            <label for="description" class="block font-medium text-sm text-gray-700">{{ __('Description') }}</label>
            <textarea id="description" name="description"
                      class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:ring focus:ring-opacity-50"
                      rows="4" required></textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="ms-3 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Submit') }}
            </button>
        </div>
    </form>
@endsection
