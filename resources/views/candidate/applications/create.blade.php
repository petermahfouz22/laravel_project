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
                        <div class="mb-4">
                            <label for="resume" class="block text-sm font-medium text-gray-700">Resume</label>
                            <input id="resume" name="resume" type="file" class="mt-1 block w-full">
                            @error('resume') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="cover_letter" class="block text-sm font-medium text-gray-700">Cover Letter</label>
                            <textarea id="cover_letter" name="cover_letter" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('cover_letter') }}</textarea>
                            @error('cover_letter') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md">Submit Application</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>