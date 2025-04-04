<x-admin-layout title="Manage Users">
  <div class="container mx-auto mt-5">
      <div class="bg-white shadow rounded-lg">
          <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg">
              <h3 class="text-lg font-semibold">Manage Users</h3>
          </div>
          <div class="p-6">
              <div class="flex border-b border-gray-200">
                  <button class="tab-button px-4 py-2 text-blue-600 border-b-2 border-blue-600 font-medium focus:outline-none active" data-tab="allUsers">All Users</button>
                  <button class="tab-button px-4 py-2 text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 font-medium focus:outline-none" data-tab="candidates">Candidates</button>
                  <button class="tab-button px-4 py-2 text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 font-medium focus:outline-none" data-tab="employers">Employers</button>
                  <button class="tab-button px-4 py-2 text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 font-medium focus:outline-none" data-tab="admins">Admins</button>
              </div>
              <div id="userTabsContent" class="mt-4">
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
                                              <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('default-avatar.png') }}" alt="User Image" class="w-12 h-12 rounded-full mx-auto">
                                          </td>
                                          <td class="px-4 py-2 text-center">{{ $user->name }}</td>
                                          <td class="px-4 py-2 text-center">{{ $user->email }}</td>
                                          <td class="px-4 py-2 text-center">{{ $user->role }}</td>
                                          <td class="px-4 py-2 text-center">
                                              <a href="{{ route('admin.users.show', $user->id) }}" class="text-white mr-2 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">
                                                  <i class="fas fa-eye"></i> View
                                              </a>
                                              <a href="{{ route('admin.users.edit', $user->id) }}" class="text-white mr-2 bg-green-600 hover:bg-green-700 font-medium rounded-lg px-4 py-2 transition shadow-md inline-block">
                                                  <i class="fas fa-edit"></i> Edit
                                              </a>
                                              <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="button" onclick="confirmDelete({{ $user->id }})" class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg px-4 py-2 transition shadow-md">
                                                      <i class="fas fa-trash"></i> Delete
                                                  </button>
                                              </form>
                                          </td>
                                      </tr>
                                  @empty
                                      <tr>
                                          <td colspan="5" class="px-4 py-6 text-center text-gray-500">No users found</td>
                                      </tr>
                                  @endforelse
                              </tbody>
                          </table>
                      </div>
                      <div class="mt-4">
                          {{ $users->links() }}
                      </div>
                  </div>
                  <div id="userTabsContent" class="mt-4">
                    <!-- All Users Tab (existing code) -->
                    <div class="tab-content hidden" id="allUsers">
                        <!-- Existing all users table -->
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
                                    @forelse($candidates as $user)
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-4 py-2 text-center">
                                                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('default-avatar.png') }}" alt="User Image" class="w-12 h-12 rounded-full mx-auto">
                                            </td>
                                            <td class="px-4 py-2 text-center">{{ $user->name }}</td>
                                            <td class="px-4 py-2 text-center">{{ $user->email }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-white mr-2 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-white mr-2 bg-green-600 hover:bg-green-700 font-medium rounded-lg px-4 py-2 transition shadow-md inline-block">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $user->id }})" class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg px-4 py-2 transition shadow-md">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">No candidates found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $candidates->links() }}
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
                                    @forelse($employers as $user)
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-4 py-2 text-center">
                                                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('default-avatar.png') }}" alt="User Image" class="w-12 h-12 rounded-full mx-auto">
                                            </td>
                                            <td class="px-4 py-2 text-center">{{ $user->name }}</td>
                                            <td class="px-4 py-2 text-center">{{ $user->email }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-white mr-2 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-white mr-2 bg-green-600 hover:bg-green-700 font-medium rounded-lg px-4 py-2 transition shadow-md inline-block">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $user->id }})" class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg px-4 py-2 transition shadow-md">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">No employers found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $employers->links() }}
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
                                    @forelse($admins as $user)
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-4 py-2 text-center">
                                                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('default-avatar.png') }}" alt="User Image" class="w-12 h-12 rounded-full mx-auto">
                                            </td>
                                            <td class="px-4 py-2 text-center">{{ $user->name }}</td>
                                            <td class="px-4 py-2 text-center">{{ $user->email }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-white mr-2 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-white mr-2 bg-green-600 hover:bg-green-700 font-medium rounded-lg px-4 py-2 transition shadow-md inline-block">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $user->id }})" class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg px-4 py-2 transition shadow-md">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">No admins found</td>
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
  </div>

  @push('scripts')
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
          document.addEventListener('DOMContentLoaded', function () {
              const tabButtons = document.querySelectorAll('.tab-button');
              const tabContents = document.querySelectorAll('.tab-content');
              tabButtons.forEach(button => {
                  button.addEventListener('click', function (event) {
                      event.preventDefault();
                      tabButtons.forEach(btn => {
                          btn.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600', 'active');
                          btn.classList.add('text-gray-600', 'hover:text-blue-600', 'hover:border-b-2', 'hover:border-blue-600');
                      });
                      this.classList.remove('text-gray-600', 'hover:text-blue-600', 'hover:border-b-2', 'hover:border-blue-600');
                      this.classList.add('text-blue-600', 'border-b-2', 'border-blue-600', 'active');
                      tabContents.forEach(content => content.classList.add('hidden'));
                      const tabId = this.getAttribute('data-tab');
                      const selectedTab = document.getElementById(tabId);
                      if (selectedTab) selectedTab.classList.remove('hidden');
                  });
              });
              tabContents.forEach(content => content.classList.add('hidden'));
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
  @endpush
</x-admin-layout>