<div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-xl font-semibold">{{ $job->title }}</h3>
    <p class="text-gray-600">{{ $job->company->name }} - {{ $job->location }}</p>
    <p class="text-sm text-gray-500 mt-2">{{ $job->work_type }} | ${{ $job->salary_min }} - ${{ $job->salary_max }}</p>
    <p class="text-sm text-gray-700 mt-2">{{ Str::limit($job->description, 100) }}</p>
    <a href="{{ route('jobs.show', $job->slug) }}" class="mt-4 inline-block text-blue-600 hover:underline">View Details</a>
</div>