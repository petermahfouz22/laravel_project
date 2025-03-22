<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('candidate.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                            <p class="mt-1 text-sm text-gray-600">Update your personal details and contact information.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Profile Image -->
                            <div class="col-span-1 md:col-span-2">
                                <div class="flex items-center">
                                    <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-100">
                                        <img id="preview" src="{{ auth()->user()->profile_photo ?? asset('images/default-avatar.png') }}" alt="Profile Photo" class="w-full h-full object-cover">
                                    </div>
                                    <div class="ml-5">
                                        <label for="photo" class="block text-sm font-medium text-gray-700">Profile photo</label>
                                        <input type="file" name="photo" id="photo" class="mt-1 block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    </div>
                                </div>
                            </div>

                            <!-- Name -->
                            <div>
                                <x-label for="name" :value="__('Full Name')" />
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', auth()->user()->name)" required autofocus />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-label for="email" :value="__('Email')" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', auth()->user()->email)" required />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-label for="phone" :value="__('Phone Number')" />
                                <x-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone', auth()->user()->phone)" />
                            </div>

                            <!-- Location -->
                            <div>
                                <x-label for="location" :value="__('Location')" />
                                <x-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', auth()->user()->location)" placeholder="City, State, Country" />
                            </div>

                            <!-- Bio -->
                            <div class="col-span-1 md:col-span-2">
                                <x-label for="bio" :value="__('Professional Summary')" />
                                <textarea id="bio" name="bio" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="A brief summary of your professional background and career objectives">{{ old('bio', auth()->user()->bio) }}</textarea>
                            </div>
                        </div>

                        <!-- Education -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Education</h3>
                                    <p class="mt-1 text-sm text-gray-600">Add your educational background</p>
                                </div>
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Add Education
                                </button>
                            </div>
                            
                            <div class="border border-gray-200 rounded-md p-4 mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-label for="school" :value="__('School/University')" />
                                        <x-input id="school" class="block mt-1 w-full" type="text" name="education[0][school]" />
                                    </div>
                                    <div>
                                        <x-label for="degree" :value="__('Degree')" />
                                        <x-input id="degree" class="block mt-1 w-full" type="text" name="education[0][degree]" placeholder="Bachelor of Science, Computer Science" />
                                    </div>
                                    <div>
                                        <x-label for="edu_start_date" :value="__('Start Date')" />
                                        <x-input id="edu_start_date" class="block mt-1 w-full" type="month" name="education[0][start_date]" />
                                    </div>
                                    <div>
                                        <x-label for="edu_end_date" :value="__('End Date (or Expected)')" />
                                        <x-input id="edu_end_date" class="block mt-1 w-full" type="month" name="education[0][end_date]" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Experience -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Work Experience</h3>
                                    <p class="mt-1 text-sm text-gray-600">Add your relevant work experience</p>
                                </div>
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Add Experience
                                </button>
                            </div>
                            
                            <div class="border border-gray-200 rounded-md p-4 mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-label for="company" :value="__('Company')" />
                                        <x-input id="company" class="block mt-1 w-full" type="text" name="experience[0][company]" />
                                    </div>
                                    <div>
                                        <x-label for="position" :value="__('Position')" />
                                        <x-input id="position" class="block mt-1 w-full" type="text" name="experience[0][position]" />
                                    </div>
                                    <div>
                                        <x-label for="exp_start_date" :value="__('Start Date')" />
                                        <x-input id="exp_start_date" class="block mt-1 w-full" type="month" name="experience[0][start_date]" />
                                    </div>
                                    <div>
                                        <x-label for="exp_end_date" :value="__('End Date')" />
                                        <div class="flex items-center mt-1">
                                            <x-input id="exp_end_date" class="block w-full" type="month" name="experience[0][end_date]" />
                                            <div class="ml-4">
                                                <input type="checkbox" id="current_job" name="experience[0][current]" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <label for="current_job" class="ml-2 text-sm text-gray-600">Current Job</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-1 md:col-span-2">
                                        <x-label for="job_description" :value="__('Description')" />
                                        <textarea id="job_description" name="experience[0][description]" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Describe your responsibilities and achievements"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Skills -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Skills</h3>
                            <div class="mb-4">
                                <x-label for="skills" :value="__('Skills (comma separated)')" />
                                <x-input id="skills" class="block mt-1 w-full" type="text" name="skills" :value="old('skills', 'Laravel, PHP, MySQL, Tailwind CSS, Vue.js')" placeholder="Laravel, PHP, MySQL, Tailwind CSS, Vue.js" />
                            </div>
                        </div>

                        <!-- Resume Upload -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Resume</h3>
                            <div class="flex items-center">
                                <div>
                                    <label for="resume" class="block text-sm font-medium text-gray-700">Upload Resume (PDF)</label>
                                    <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx" class="mt-1 block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                <div class="ml-4">
                                    @if(auth()->user()->resume)
                                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500">View Current Resume</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <x-button class="ml-3">
                                {{ __('Save Profile') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>