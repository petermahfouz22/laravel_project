<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Listings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('jobs.index') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div class="md:col-span-2">
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <div class="mt-1">
                                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Job title, skills, or company">
                                </div>
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                <div class="mt-1">
                                    <input type="text" name="location" id="location" value="{{ request('location') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="City, state, or remote">
                                </div>
                            </div>

                            <!-- Job Type -->
                            <div>
                                <label for="job_type" class="block text-sm font-medium text-gray-700">Job Type</label>
                                <select id="job_type" name="job_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">All Types</option>
                                    <option value="full_time" {{ request('job_type') == 'full_time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="part_time" {{ request('job_type') == 'part_time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="contract" {{ request('job_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="freelance" {{ request('job_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                                    <option value="internship" {{ request('job_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                            <!-- Experience Level -->
                            <div>
                                <label for="experience" class="block text-sm font-medium text-gray-700">Experience Level</label>
                                <select id="experience" name="experience" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">All Levels</option>
                                    <option value="entry" {{ request('experience') == 'entry' ? 'selected' : '' }}>Entry Level</option>
                                    <option value="mid" {{ request('experience') == 'mid' ? 'selected' : '' }}>Mid Level</option>
                                    <option value="senior" {{ request('experience') == 'senior' ? 'selected' : '' }}>Senior Level</option>
                                </select>
                            </div>

                            <!-- Salary Range -->
                            <div>
                                <label for="salary_min" class="block text-sm font-medium text-gray-700">Minimum Salary</label>
                                <input type="number" name="salary_min" id="salary_min" value="{{ request('salary_min') }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Min salary">
                            </div>

                            <!-- Date Posted -->
                            <div>
                                <label for="posted" class="block text-sm font-medium text-gray-700">Date Posted</label>
                                <select id="posted" name="posted" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Any Time</option>
                                    <option value="today" {{ request('posted') == 'today' ? 'selected' : '' }}>Today</option>
                                    <option value="week" {{ request('posted') == 'week' ? 'selected' : '' }}>Past Week</option>
                                    <option value="month" {{ request('posted') == 'month' ? 'selected' : '' }}>Past Month</option>
                                </select>
                            </div>

                            <!-- Submit -->
                            <div class="flex items-end">
                                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Search Jobs
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200">
                    <!-- Result Stats -->
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">156</span> results
                            </p>
                            <div>
                                <select id="sorting" name="sorting" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>Most Relevant</option>
                                    <option>Newest</option>
                                    <option>Salary: High to Low</option>
                                    <option>Salary: Low to High</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Job Listings -->
                    <ul class="divide-y divide-gray-200">
                        @for ($i = 1; $i <= 5; $i++)
                        <li>
                            <div class="px-6 py-4 flex items-center">
                                <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-md flex items-center justify-center">
                                    <span class="text-xl font-bold text-gray-500">{{ chr(64 + $i) }}</span>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <div>
                                            <h4 class="text-lg font-medium text-indigo-600 hover:text-indigo-500">
                                                <a href="{{ route('jobs.show', $i) }}">{{ ['Laravel Developer', 'Full Stack Engineer', 'Backend Developer', 'Frontend Developer', 'DevOps Engineer'][$i-1] }}</a>
                                            </h4>
                                            <p class="text-gray-700">{{ ['TechCorp Inc', 'WebSolutions Ltd', 'Digital Innovations', 'CodeMasters', 'Cloud Systems'][$i-1] }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="button" class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-2 flex flex-wrap">
                                        <div class="mr-4 mt-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ ['Full-time', 'Part-time', 'Contract', 'Full-time', 'Full-time'][$i-1] }}
                                            </span>
                                        </div>
                                        <div class="mr-4 mt-2">
                                            <span class="inline-flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                </svg>
                                                {{ ['San Francisco, CA', 'Remote', 'New York, NY', 'Chicago, IL', 'Austin, TX'][$i-1] }}
                                            </span>
                                        </div>
                                        <div class="mr-4 mt-2">
                                            <span class="inline-flex items-center text-sm text