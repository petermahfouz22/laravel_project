<div>
    <!-- Very little is needed to make a happy life. - Marcus Aurelius -->
</div><!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <x-navigation />

    <div class="container mx-auto">
        {{ $slot }}
    </div>

    @stack('scripts')
</body>
</html>