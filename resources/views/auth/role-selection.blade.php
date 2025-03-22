<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl w-full space-y-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">Join Job Finder</h1>
                <p class="mt-2 text-lg text-gray-600">Choose your role to get started</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Candidate Card -->
                <a href="{{ route('register.candidate') }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <h2 class="mt-4 text-xl font-semibold text-gray-900">Candidate</h2>
                        <p class="mt-2 text-gray-600">Find your dream job and build your career.</p>
                    </div>
                </a>
                <!-- Employer Card -->
                <a href="{{ route('register.employer') }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"></path>
                        </svg>
                        <h2 class="mt-4 text-xl font-semibold text-gray-900">Employer</h2>
                        <p class="mt-2 text-gray-600">Post jobs and hire top talent.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>