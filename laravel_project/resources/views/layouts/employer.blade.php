<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-50">
    <nav class="bg-gray-800 text-white shadow-md p-4 flex justify-between items-center">
        <!-- Left side: Employer -->
        <div class="flex items-center">
            <a href="/" class="text-lg font-semibold">JopFinder</a>
        </div>

        <!-- Center: Navigation Links -->
        <div class="flex items-center space-x-6 absolute left-1/2 transform -translate-x-1/2">
            <a href="/" class="hover:text-gray-300">Home</a>
            <a href="/about" class="hover:text-gray-300">About</a>
            <a href="/myposts" class="hover:text-gray-300">MyPosts</a>
            <a href="/contact" class="hover:text-gray-300">Contact Us</a>
        </div>

        <!-- Right side: Dropdown and Post Job Button -->
        <div class="flex items-center space-x-4">
            <!-- Post Job Button -->
            <button class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white">
                Post a Job
            </button>

            <!-- Dropdown Menu -->
            <div class="relative group">
                <button class="flex items-center space-x-2 bg-gray-700 px-3 py-2 rounded hover:bg-gray-600">
                    <span>John Doe</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <!-- Dropdown Content -->
                <div class="absolute right-0 mt-1 w-48 bg-white rounded-md shadow-lg hidden group-hover:block">
                    <a href="/profile" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>
                    <a href="/logout" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
    </nav>



    <!-- Footer -->
<!-- Footer -->
<footer class="bg-gray-800 text-white py-6 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h5 class="text-lg font-semibold mb-4">JobFinder</h5>
                    <p class="text-gray-300">Find and manage the best talent for your organization.</p>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Quick Links</h5>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-gray-300 hover:text-white">Home</a></li>
                        <li><a href="/candidates" class="text-gray-300 hover:text-white">Candidates</a></li>
                        <li><a href="/privacy" class="text-gray-300 hover:text-white">Privacy Policy</a></li>
                        <li><a href="/terms" class="text-gray-300 hover:text-white">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Contact Us</h5>
                    <address class="not-italic">
                        <p class="text-gray-300">Email: info@candidateportal.com</p>
                        <p class="text-gray-300">Phone: (123) 456-7890</p>
                    </address>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-4 text-center">
                <p class="text-gray-300">&copy; {{ date('Y') }} JobFinder. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
