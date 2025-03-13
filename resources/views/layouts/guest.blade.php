<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen">
        @yield('content')  <!-- This is where the child view content will be injected -->
    </div>
    
    <!-- Optional: Add this if you need to yield scripts -->
    @stack('scripts')
</body>
</html>