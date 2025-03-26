<x-guest-layout>
    <!-- Hero Section with Gradient Blue Background -->
    <header class="bg-gradient-to-r from-blue-700 to-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-extrabold mb-4 tracking-tight">Find Your Dream Job</h1>
            <p class="text-xl text-blue-100 mb-6">Explore opportunities as a candidate or post jobs as an employer</p>
            <div class="space-x-4">
                <a href="{{ route('register') }}" class="inline-block bg-white text-blue-800 hover:bg-blue-50 px-8 py-3 rounded-lg font-semibold transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                    Get Started
                </a>
                <a href="{{ route('login') }}" class="inline-block border border-white text-white hover:bg-blue-800 px-8 py-3 rounded-lg font-semibold transition duration-300 ease-in-out">
                    Log In
                </a>
            </div>
        </div>
    </header>

    <!-- Job Listings Section -->
    <main class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-blue-900 mb-8 text-center">Latest Job Opportunities</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($jobs as $job)
                    <div class="bg-white shadow-md rounded-xl overflow-hidden hover:shadow-xl transition duration-300 ease-in-out border-l-4 border-blue-600">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-blue-900 mb-3">{{ $job->title }}</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $job->description }}</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-sm text-gray-500">{{ $job->created_at->diffForHumans() }}</span>
                                <a href="{{ route('jobs.show', ['job' => $job->id]) }}" class="text-blue-600 hover:text-blue-800 font-medium transition duration-200">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($jobs->isEmpty())
                <div class="text-center py-12">
                    <p class="text-xl text-gray-500">No jobs available at the moment</p>
                </div>
            @endif

        </div>
    </main>
</x-guest-layout>