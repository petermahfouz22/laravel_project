<x-admin-layout title="Job Listings">
    <div class="container mx-auto mt-5">
        <div class="bg-white shadow rounded-lg">
            <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg">
                <h3 class="text-lg font-semibold">Job Listings</h3>
            
                {{-- <a 
                href="{{ route('admin.jobs.pending') }}" 
                class="btn text-white bg-purple-600 hover:bg-blue-700 px-4 py-1 rounded-lg"
            >
            pending Jobs
            </a> --}}
      </div>
            <!-- Filters -->
            <form action="{{ route('admin.jobs.index') }}" method="GET" class="p-4">
                <div class="grid md:grid-cols-3 gap-4">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search jobs..." 
                        value="{{ request('search') }}" 
                        class="input input-bordered w-full"
                    >
                    
                    <select name="category" class="select select-bordered w-full">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option 
                                value="{{ $cat->id }}" 
                                {{ request('category') == $cat->id ? 'selected' : '' }}
                            >
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="work_type" class="select select-bordered w-full">
                        <option value="">All Work Types</option>
                        <option value="remote" {{ request('work_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                        <option value="onsite" {{ request('work_type') == 'onsite' ? 'selected' : '' }}>On-site</option>
                        <option value="hybrid" {{ request('work_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <div class="tabs">
                        <a 
                            href="{{ route('admin.jobs.index', array_merge(request()->except('status', 'page'), ['status' => 'all'])) }}" 
                            class="btn text-white bg-blue-600 hover:bg-blue-700 mx-1 px-3 py-2 rounded-lg tab {{ request('status', 'all') == 'all' ? 'tab-active' : '' }}"
                        >
                            All Jobs
                        </a>
                        <a 
                            href="{{ route('admin.jobs.index', array_merge(request()->except('status', 'page'), ['status' => 'pending'])) }}" 
                            class="btn text-white bg-blue-600 hover:bg-blue-700 mx-1 px-3 py-2 rounded-lg tab {{ request('status') == 'pending' ? 'tab-active' : '' }}"
                        >
                            Pending Approval
                        </a>
                        <a 
                            href="{{ route('admin.jobs.index', array_merge(request()->except('status', 'page'), ['status' => 'active'])) }}" 
                            class="btn text-white bg-blue-600 hover:bg-blue-700 mx-1 px-3 py-2 rounded-lg tab {{ request('status') == 'active' ? 'tab-active' : '' }}"
                        >
                            Active Jobs
                        </a>
                        <a 
                            href="{{ route('admin.jobs.index', array_merge(request()->except('status', 'page'), ['status' => 'inactive'])) }}" 
                            class="btn text-white bg-blue-600 hover:bg-blue-700 mx-1 px-3 py-2 rounded-lg tab {{ request('status') == 'inactive' ? 'tab-active' : '' }}"
                        >
                            Inactive Jobs
                        </a>
                    </div>

                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>

            <!-- Job Listings Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 border border-gray-300">Title</th>
                            <th class="px-4 py-2 border border-gray-300">Company</th>
                            <th class="px-4 py-2 border border-gray-300">Category</th>
                            <th class="px-4 py-2 border border-gray-300">Status</th>
                            <th class="px-4 py-2 border border-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobs as $job)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 text-center">{{ $job->title }}</td>
                                <td class="px-4 py-2 text-center">{{ $job->company->name }}</td>
                                <td class="px-4 py-2 text-center">{{ $job->category->name }}</td>
                                <td class="px-4 py-2 text-center">
                                    @if(!$job->is_approved)
                                        <span class="  badge badge-warning">Pending Approval</span>
                                    @elseif(!$job->is_active)
                                        <span class=" badge badge-error">Inactive</span>
                                    @else
                                        <span class=" badge badge-success">Active</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a 
                                        href="{{ route('admin.jobs.show', $job->slug) }}" 
                                        class="btn text-white bg-purple-600 hover:bg-blue-700 px-4 py-1 rounded-lg"
                                    >
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                    No job listings found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 px-6">
                {{ $jobs->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>