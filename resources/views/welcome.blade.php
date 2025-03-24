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
          @foreach ($jobs as $job)
              <div class="bg-white shadow-md rounded-md p-6">
                  <h3 class="text-lg font-semibold">{{ $job->title }}</h3>
                  <p class="text-gray-600 mt-2">{{ $job->description }}</p>
                  <div class="mt-4 flex justify-between items-center">
                      <span class="text-gray-500">{{ $job->created_at->diffForHumans() }}</span>
                      <a href="{{ route('candidate.jobs.show', ['job' => $job->id]) }}" class="text-blue-600 hover:underline">View Job</a>
                  </div>
              </div>
          @endforeach
      </div>
      <div class="mt-6 text-center">
          <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in to see more</a>
      </div>
  </main>
</x-guest-layout>