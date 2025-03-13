@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pending Approvals -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Pending Job Approvals</h2>
                <div class="space-y-4">
                    @foreach($pendingJobs as $job)
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-center">
                            <h3 class="font-medium">{{ $job->title }}</h3>
                            <span class="text-sm text-gray-600">{{ $job->company->name }}</span>
                        </div>
                        <div class="mt-2 flex gap-2">
                            <button class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded">Approve</button>
                            <button class="text-sm bg-red-100 text-red-800 px-2 py-1 rounded">Reject</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- User Management -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">User Management</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-left text-sm text-gray-600">
                                <th class="pb-2">Name</th>
                                <th class="pb-2">Role</th>
                                <th class="pb-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="border-t">
                                <td class="py-2">{{ $user->name }}</td>
                                <td class="py-2">{{ ucfirst($user->role) }}</td>
                                <td class="py-2">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection