<x-guest-layout>
    <!-- Hero Section -->
    <header class="bg-blue-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold">Find Your Dream Job</h1>
            <p class="mt-2 text-lg">Explore opportunities as a candidate or post jobs as an employer.</p>
            <a href="{{ route('register') }}" class="mt-4 inline-block bg-white text-blue-600 px-6 py-3 rounded-md font-semibold">Get Started</a>
        </div>
    </header>

    <!-- Job Listings Preview -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h2 class="text-2xl font-semibold mb-6">Latest Jobs</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($jobs as $job)
                @include('components.job-card', ['job' => $job])
            @empty
                <p class="col-span-full text-center text-gray-500">No jobs available yet.</p>
            @endforelse
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in to see more</a>
        </div>
    </main>
</x-guest-layout>