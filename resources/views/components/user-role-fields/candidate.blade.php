{{-- resources/views/components/user-role-fields/candidate.blade.php --}}
<div>
  <div>
      <label for="skills" class="block text-sm font-medium text-gray-700">Skills</label>
      <input 
          type="text" 
          name="skills" 
          id="skills" 
          value="{{ old('skills', $user->candidate ? $user->candidate->skills : '') }}" 
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
          placeholder="Enter skills separated by commas"
      >
      @error('skills')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
      @enderror
  </div>

  <div class="mt-4">
      <label for="job_preferences" class="block text-sm font-medium text-gray-700">Job Preferences</label>
      <textarea 
          name="job_preferences" 
          id="job_preferences" 
          rows="3"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
          placeholder="Describe your job preferences"
      >{{ old('job_preferences', $user->candidate ? $user->candidate->job_preferences : '') }}</textarea>
      @error('job_preferences')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
      @enderror
  </div>
</div>