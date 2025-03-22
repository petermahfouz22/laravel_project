<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Browse Jobs') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and filter section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('candidate.jobs.search') }}" method="GET" class="space-y-4">
                        <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                            <!-- Keyword search -->
                            <div class="flex-1">
                                <label for="keyword" class="block text-sm font-medium text-gray-700">Keyword</label>
                                <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            
                            <!-- Category filter -->
                            <div class="flex-1">
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category_id" id="category_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                                Search Jobs
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Jobs list -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-4">{{ request('keyword') || request('category_id') ? 'Search Results' : 'Available Jobs' }}</h3>
                    
                    @if($jobs->isEmpty())
                        <p class="text-gray-600">No jobs found matching your criteria.</p>
                    @else
                        <div class="space-y-6">
                            @foreach($jobs as $job)
                                <div class="border-b pb-6">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-xl font-semibold">
                                                <a href="{{ route('candidate.jobs.show', $job) }}" class="text-blue-600 hover:underline">
                                                    {{ $job->title }}
                                                </a>
                                            </h4>
                                            <p class="text-gray-600">{{ $job->company_name }}</p>
                                            <p class="text-sm">
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                                    {{ $job->category->name }}
                                                </span>
                                            </p>
                                        </div>
                                        <div>
                                            <a href="{{ route('candidate.applications.create', ['job' => $job->id])) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm">
                                                Apply Now
                                            </a>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-gray-700">{{ Str::limit($job->description, 200) }}</p>
                                    <div class="mt-2 text-sm text-gray-500">
                                        <span>Posted: {{ $job->created_at->diffForHumans() }}</span>
                                        <span class="ml-4">Deadline: {{ $job->application_deadline->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $jobs->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>