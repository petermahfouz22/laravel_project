{{-- resources/views/components/user-role-fields/admin.blade.php --}}
<div>
  <label for="admin_level" class="block text-sm font-medium text-gray-700">Admin Level</label>
  <select 
      name="admin_level" 
      id="admin_level" 
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
  >
      <option value="super_admin" {{ old('admin_level', $user->admin_level) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
      <option value="content_admin" {{ old('admin_level', $user->admin_level) == 'content_admin' ? 'selected' : '' }}>Content Admin</option>
      <option value="user_admin" {{ old('admin_level', $user->admin_level) == 'user_admin' ? 'selected' : '' }}>User Admin</option>
  </select>
  @error('admin_level')
      <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
  @enderror
</div>