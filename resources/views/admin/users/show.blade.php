@extends('layouts.admin')

@section('content')
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
        <h2 class="text-2xl font-semibold">User Details</h2>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>
@endsection