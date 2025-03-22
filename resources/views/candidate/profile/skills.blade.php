@extends('candidate.profile.index')

@section('profile-content')
<h2 class="text-xl font-semibold mb-4">Skills</h2>
<div class="mb-6">
    @foreach ($skills as $skill)
        <span class="inline-block bg-gray-200 text-gray-700 px-3 py-1 rounded-full mr-2 mb-2">{{ $skill->name }}</span>
    @endforeach
</div>
<form method="POST" action="{{ route('candidate.profile.skills.update') }}">
    @csrf
    @include('components.candidate.skills-input')
    <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Add Skill</button>
</form>
@endsection