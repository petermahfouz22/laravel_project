{{-- resources/views/components/user-role-fields/employer.blade.php --}}
<div>
  <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
  <input 
      type="text" 
      name="company_name" 
      id="company_name" 
      value="{{ old('company_name', $user->company ? $user->company->name : '') }}" 
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
  >
  @error('company_name')
      <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
  @enderror
</div>