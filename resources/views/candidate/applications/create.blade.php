<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Apply for Job') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-4">Apply for {{ $job->title }}</h1>
                    <form method="POST" action="{{ route('candidate.applications.store', ['job' => $job->id]) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $job->id }}">

                        <!-- Full Name -->
                        <div class="mb-4">
                            <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                            <input id="full_name" name="full_name" type="text" value="{{ old('full_name', auth()->user()->name) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            @error('full_name') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone *</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone', auth()->user()->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            @error('phone') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Cover Letter -->
                        <div class="mb-4">
                            <label for="cover_letter" class="block text-sm font-medium text-gray-700">Cover Letter</label>
                            <textarea id="cover_letter" name="cover_letter" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('cover_letter') }}</textarea>
                            @error('cover_letter') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Resume -->
                        <div class="mb-4">
                            <label for="resume" class="block text-sm font-medium text-gray-700">Resume *</label>
                            <input id="resume" name="resume" type="file" class="mt-1 block w-full" required>
                            @error('resume') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Expected Salary -->
                        <div class="mb-4">
                            <label for="expected_salary" class="block text-sm font-medium text-gray-700">Expected Salary *</label>
                            <input id="expected_salary" name="expected_salary" type="text" value="{{ old('expected_salary') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            @error('expected_salary') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="terms" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                                <span class="ml-2 text-sm text-gray-600">I agree to the terms and conditions & privacy policy</span>
                            </label>
                            @error('terms') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md">Apply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>