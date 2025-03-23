@extends('layouts.admin')

@section('content')
    <div class="container mx-auto mt-5">
        <div class="bg-white shadow rounded-lg">
            <!-- Header -->
            <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg">
                <h3 class="text-lg font-semibold">Manage Users</h3>
            </div>

            <!-- Main Content -->
            <div class="p-6">
                <!-- Tab Navigation -->
                <div class="flex border-b border-gray-200">
                    <button
                        class="tab-button px-4 py-2 text-blue-600 border-b-2 border-blue-600 font-medium focus:outline-none active"
                        data-tab="allUsers">All Users</button>
                    <button
                        class="tab-button px-4 py-2 text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 font-medium focus:outline-none"
                        data-tab="candidates">Candidates</button>
                    <button
                        class="tab-button px-4 py-2 text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 font-medium focus:outline-none"
                        data-tab="employers">Employers</button>
                    <button
                        class="tab-button px-4 py-2 text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 font-medium focus:outline-none"
                        data-tab="admins">Admins</button>
                </div>

                <!-- Tab Content -->
                <div id="userTabsContent" class="mt-4">
                    <!-- All Users Tab -->
                    <div class="tab-content" id="allUsers">
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="px-4 py-2 border border-gray-300">Image</th>
                                        <th class="px-4 py-2 border border-gray-300">Name</th>
                                        <th class="px-4 py-2 border border-gray-300">Email</th>
                                        <th class="px-4 py-2 border border-gray-300">Role</th>
                                        <th class="px-4 py-2 border border-gray-300">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-4 py-2 text-center">
                                                <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('default-avatar.png') }}"
                                                    alt="User Image" class="w-12 h-12 rounded-full mx-auto">
                                            </td>
                                            <td class="px-4 py-2 text-center">{{ $user->name }}</td>
                                            <td class="px-4 py-2 text-center">{{ $user->email }}</td>
                                            <td class="px-4 py-2 text-center">{{ $user->role }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('admin.users.show', $user->id) }}"
                                                    class="text-white mr-2 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="text-white mr-2 bg-green-600 hover:bg-green-700 font-medium rounded-lg px-4 py-2 transition shadow-md inline-block">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>

                                                <form id="delete-form-{{ $user->id }}"
                                                    action="{{ route('deleteUser', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $user->id }})"
                                                        class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg px-4 py-2 transition shadow-md">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">No users found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    </div>

                    <!-- Candidates Tab -->
                    <div class="tab-content hidden" id="candidates">
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="px-4 py-2 border border-gray-300">Image</th>
                                        <th class="px-4 py-2 border border-gray-300">Name</th>
                                        <th class="px-4 py-2 border border-gray-300">Email</th>
                                        <th class="px-4 py-2 border border-gray-300">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($candidates as $candidate)
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-4 py-2 text-center">
                                                <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('default-avatar.png') }}"
                                                    alt="User Image" class="w-12 h-12 rounded-full mx-auto">
                                            </td>
                                            <td class="px-4 py-2 text-center">{{ $candidate->name }}</td>
                                            <td class="px-4 py-2 text-center">{{ $candidate->email }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('admin.users.show', $candidate->id) }}"
                                                    class="text-white mr-2 bg-blue-600 hover:bg-blue-700 font-medium rounded-lg px-4 py-2 transition shadow-md inline-block">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('admin.users.edit', $candidate->id) }}"
                                                    class="text-white mr-2 bg-green-600 hover:bg-green-700 font-medium rounded-lg px-4 py-2 transition shadow-md inline-block">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form id="delete-form-{{ $candidate->id }}"
                                                    action="{{ route('deleteUser', $candidate->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $user->id }})"
                                                        class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg px-4 py-2 transition shadow-md">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $candidates->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Employers Tab -->
                    <div class="tab-content hidden" id="employers">
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="px-4 py-2 border border-gray-300">Image</th>
                                        <th class="px-4 py-2 border border-gray-300">Name</th>
                                        <th class="px-4 py-2 border border-gray-300">Email</th>
                                        <th class="px-4 py-2 border border-gray-300">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($employers as $employer)
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-4 py-2 text-center">
                                                <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('default-avatar.png') }}"
                                                    alt="User Image" class="w-12 h-12 rounded-full mx-auto">
                                            </td>
                                            <td class="px-4 py-2 text-center">{{ $employer->name }}</td>
                                            <td class="px-4 py-2 text-center">{{ $employer->email }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('admin.users.show', $employer->id) }}"
                                                    class="text-white mr-2 bg-blue-600 hover:bg-blue-700 font-medium rounded-lg px-4 py-2 transition shadow-md inline-block">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('admin.users.edit', $employer->id) }}"
                                                    class="text-white mr-2 bg-green-600 hover:bg-green-700 font-medium rounded-lg px-4 py-2 transition shadow-md inline-block">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form id="delete-form-{{ $employer->id }}"
                                                    action="{{ route('deleteUser', $employer->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $user->id }})"
                                                        class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg px-4 py-2 transition shadow-md">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-6 text-center text-gray-500">No employers found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $employers->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Admins Tab -->
                    <div class="tab-content hidden" id="admins">
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="px-4 py-2 border border-gray-300">Image</th>
                                        <th class="px-4 py-2 border border-gray-300">Name</th>
                                        <th class="px-4 py-2 border border-gray-300">Email</th>
                                        <th class="px-4 py-2 border border-gray-300">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($admins as $admin)
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-4 py-2 text-center">
                                                <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('default-avatar.png') }}"
                                                    alt="User Image" class="w-12 h-12 rounded-full mx-auto">
                                            </td>
                                            <td class="px-4 py-2 text-center">{{ $admin->name }}</td>
                                            <td class="px-4 py-2 text-center">{{ $admin->email }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('admin.users.show', $admin->id) }}"
                                                    class="text-white mr-2 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg px-4 py-2 transition duration-300 ease-in-out shadow-md inline-block">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href=""
                                                    class="text-white mr-2 bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg px-4 py-2 transition duration-300 ease-in-out shadow-md inline-block">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form id="delete-form-{{ $admin->id }}"
                                                    action="{{ route('deleteUser', $admin->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $admin->id }})"
                                                        class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg px-4 py-2 transition shadow-md">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-6 text-center text-gray-500">No admins found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $admins->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom JavaScript for Tab Switching -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    // Prevent default behavior
                    event.preventDefault();

                    // Reset all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600', 'active');
                        btn.classList.add('text-gray-600', 'hover:text-blue-600', 'hover:border-b-2', 'hover:border-blue-600');
                    });

                    // Set active button
                    this.classList.remove('text-gray-600', 'hover:text-blue-600', 'hover:border-b-2', 'hover:border-blue-600');
                    this.classList.add('text-blue-600', 'border-b-2', 'border-blue-600', 'active');

                    // Hide all content
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Show the selected tab
                    const tabId = this.getAttribute('data-tab');
                    const selectedTab = document.getElementById(tabId);
                    if (selectedTab) {
                        selectedTab.classList.remove('hidden');
                    }
                });
            });

            // Show the first tab by default (All Users)
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById('allUsers').classList.remove('hidden');
        });
        function confirmDelete(userId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            });
        }

    </script>
@endsection