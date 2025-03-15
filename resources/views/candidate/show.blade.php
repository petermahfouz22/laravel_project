<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Apply for Job') }}
            </h2>
            <div>
                <a href="{{ route('jobs.show', 1) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Back to Job
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Job Brief Summary -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-8">
                        <div class="flex items-center">
                            <div class="h-12 w-12 bg-indigo-100 rounded-md flex items-center justify-center">
                                <span class="text-lg font-bold text-indigo-600">TC</span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Laravel Developer</h3>
                                <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        TechCorp Inc
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        San Francisco, CA
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        $80,000 - $110,000
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Full-time
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Application Form -->
                    <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="job_id" value="1">

                        <!-- Personal Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                    <x-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone', auth()->user()->phone)" required />
                                </div>

                                <!-- Location -->
                                <div>
                                    <x-label for="location" :value="__('Location')" />
                                    <x-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', auth()->user()->location)" placeholder="City, State, Country" required />
                                </div>
                            </div>
                        </div>

                        <!-- Resume -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Resume/CV</h3>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex items-center">
                                            <input id="use_profile_resume" name="use_profile_resume" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label for="use_profile_resume" class="ml-2 block text-sm text-gray-900">
                                                Use resume from my profile
                                            </label>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">We'll use the most recent resume you've uploaded to your profile.</p>
                                    </div>
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="mt-4 flex justify-center text-sm text-gray-600">
                                            <label for="resume" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                <span>Upload a file</span>
                                                <input id="resume" name="resume" type="file" class="sr-only" accept=".pdf,.doc,.docx">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PDF, DOC, or DOCX up to 5MB
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cover Letter -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Cover Letter</h3>
                                <div class="flex items-center">
                                    <input id="no_cover_letter" name="no_cover_letter" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="no_cover_letter" class="ml-2 block text-sm text-gray-900">
                                        No cover letter
                                    </label>
                                </div>
                            </div>
                            <div>
                                <textarea id="cover_letter" name="cover_letter" rows="8" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Write a cover letter that explains why you're a good fit for this position..."></textarea>
                                <p class="mt-2 text-sm text-gray-500">
                                    A personalized cover letter helps your application stand out.
                                </p>
                            </div>
                        </div>

                        <!-- Additional Questions -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Questions</h3>
                            
                            <!-- Years of Experience -->
                            <div class="mb-6">
                                <x-label for="experience_years" :value="__('How many years of experience do you have with Laravel?')" />
                                <select id="experience_years" name="experience_years" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Select an option</option>
                                    <option value="less_than_1">Less than 1 year</option>
                                    <option value="1_to_3">1-3 years</option>
                                    <option value="3_to_5">3-5 years</option>
                                    <option value="more_than_5">More than 5 years</option>
                                </select>
                            </div>
                            
                            <!-- Work Type -->
                            <div class="mb-6">
                                <x-label for="work_type_preference" :value="__('Are you comfortable with a hybrid work environment (3 days in office, 2 days remote)?')" />
                                <div class="mt-4 space-y-4">
                                    <div class="flex items-center">
                                        <input id="work_type_yes" name="work_type_preference" type="radio" value="yes" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="work_type_yes" class="ml-3 block text-sm font-medium text-gray-700">
                                            Yes, I'm comfortable with this arrangement
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="work_type_no" name="work_type