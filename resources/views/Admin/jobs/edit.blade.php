<x-admin-layout title="Edit Job Listing">
  <div class="container mx-auto mt-5">
      <div class="bg-white shadow rounded-lg">
          <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg">
              <h3 class="text-lg font-semibold">Edit Job Listing</h3>
          </div>

          <form 
              action="{{ route('admin.jobs.update', $job->id) }}" 
              method="POST" 
              class="p-6 space-y-6"
          >
              @csrf
              @method('PUT')

              <div class="grid md:grid-cols-2 gap-6">
                  <div>
                      <label class="block mb-2 font-medium">Job Title</label>
                      <input 
                          type="text" 
                          name="title" 
                          value="{{ old('title', $job->title) }}"
                          class="input input-bordered w-full"
                          required
                      >
                  </div>

                  <div>
                      <label class="block mb-2 font-medium">Category</label>
                      <select name="category_id" class="select select-bordered w-full" required>
                          @foreach($categories as $category)
                              <option 
                                  value="{{ $category->id }}"
                                  {{ $job->category_id == $category->id ? 'selected' : '' }}
                              >
                                  {{ $category->name }}
                              </option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <div class="grid md:grid-cols-2 gap-6">
                  <div>
                      <label class="block mb-2 font-medium">Location</label>
                      <input 
                          type="text" 
                          name="location" 
                          value="{{ old('location', $job->location) }}"
                          class="input input-bordered w-full"
                          required
                      >
                  </div>

                  <div>
                      <label class="block mb-2 font-medium">Work Type</label>
                      <select name="work_type" class="select select-bordered w-full" required>
                          <option value="remote" {{ $job->work_type == 'remote' ? 'selected' : '' }}>Remote</option>
                          <option value="onsite" {{ $job->work_type == 'onsite' ? 'selected' : '' }}>On-site</option>
                          <option value="hybrid" {{ $job->work_type == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                      </select>
                  </div>
              </div>

              <div class="grid md:grid-cols-2 gap-6">
                  <div>
                      <label class="block mb-2 font-medium">Minimum Salary</label>
                      <input 
                          type="number" 
                          name="salary_min" 
                          value="{{ old('salary_min', $job->salary_min) }}"
                          class="input input-bordered w-full"
                      >
                  </div>

                  <div>
                      <label class="block mb-2 font-medium">Maximum Salary</label>
                      <input 
                          type="number" 
                          name="salary_max" 
                          value="{{ old('salary_max', $job->salary_max) }}"
                          class="input input-bordered w-full"
                      >
                  </div>
              </div>

              <div class="grid md:grid-cols-2 gap-6">
                  <div>
                      <label class="block mb-2 font-medium">Application Deadline</label>
                      <input 
                          type="date" 
                          name="application_deadline" 
                          value="{{ old('application_deadline', $job->application_deadline ? $job->application_deadline->format('Y-m-d') : '') }}"
                          class="input input-bordered w-full"
                          required
                      >
                  </div>

                  <div>
                      <label class="block mb-2 font-medium">Technologies</label>
                      <select 
                          name="technologies[]" 
                          multiple 
                          class="select select-bordered w-full" 
                          data-placeholder="Select technologies"
                      >
                          @foreach($technologies as $technology)
                              <option 
                                  value="{{ $technology->id }}"
                                  {{ $job->technologies->contains($technology->id) ? 'selected' : '' }}
                              >
                                  {{ $technology->name }}
                              </option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <div>
                  <label class="block mb-2 font-medium">Job Description</label>
                  <textarea 
                      name="description" 
                      class="textarea textarea-bordered w-full h-32"
                      required
                  >{{ old('description', $job->description) }}</textarea>
              </div>

              <div>
                  <label class="block mb-2 font-medium">Responsibilities</label>
                  <textarea 
                      name="responsibilities" 
                      class="textarea textarea-bordered w-full h-32"
                      required
                  >{{ old('responsibilities', $job->responsibilities) }}</textarea>
              </div>

              <div>
                  <label class="block mb-2 font-medium">Requirements</label>
                  <textarea 
                      name="requirements" 
                      class="textarea textarea-bordered w-full h-32"
                      required
                  >{{ old('requirements', $job->requirements) }}</textarea>
              </div>

              <div class="flex items-center space-x-4">
                  @if(auth()->user()->isAdmin())
                      <div class="flex items-center space-x-2">
                          <label class="font-medium">Approval Status</label>
                          <input 
                              type="checkbox" 
                              name="is_approved" 
                              class="checkbox checkbox-primary"
                              {{ $job->is_approved ? 'checked' : '' }}
                          >
                      </div>
                  @endif

                  <button type="submit" class="btn text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">
                      Update Job Listing
                  </button>
              </div>
          </form>
      </div>
  </div>
</x-admin-layout>