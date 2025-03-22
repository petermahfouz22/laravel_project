<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Resumes</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Upload Resume</h1>
                    <form method="POST" action="{{ route('candidate.resume.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="resume" class="block text-sm font-medium text-gray-700">Resume</label>
                            <input id="resume" name="resume" type="file" class="mt-1 block w-full">
                            @error('resume') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md">Upload Resume</button>
                    </form>

                    <h2 class="text-xl font-semibold mt-6 mb-4">Your Resumes</h2>
                    @if ($user->resumes->isEmpty())
                        <p>No resumes uploaded yet.</p>
                    @else
                        <ul class="list-disc pl-5">
                            @foreach ($user->resumes as $resume)
                                <li>
                                    {{ basename($resume->path) }} (Uploaded: {{ $resume->created_at->format('M d, Y') }})
                                    <a href="{{ asset('storage/' . $resume->path) }}" class="text-blue-600 hover:underline">Download</a>
                                    <form action="{{ route('candidate.resume.delete', $resume->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>