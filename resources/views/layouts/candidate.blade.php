<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Candidate System')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- You can include your custom CSS here -->
    @yield('styles')
</head>
<body class="flex flex-col min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-gray-800 text-white shadow-md p-4 flex justify-between items-center">
        <!-- Left side: Employer -->
        <div class="flex items-center">
            <a href="/" class="text-lg font-semibold">JobFinder</a>
        </div>

        <!-- Center: Navigation Links -->
        <div class="flex items-center space-x-6 absolute left-1/2 transform -translate-x-1/2">
            <a href="/" class="hover:text-gray-300">Home</a>
            <a href="/" class="hover:text-gray-300">FAQ</a>
            <a href="/about" class="hover:text-gray-300">About</a>
            <a href="/myposts" class="hover:text-gray-300">Applications</a>
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

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex-grow">
        @yield('content')
    </main>

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

    <!-- Mobile menu toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('[aria-controls="mobile-menu"]');
            const mobileMenu = document.getElementById('mobile-menu');
            
            menuButton.addEventListener('click', function() {
                const expanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !expanded);
                
                // Toggle visibility of mobile menu
                mobileMenu.classList.toggle('hidden');
                
                // Toggle menu icons
                const openIcon = this.querySelector('svg.block');
                const closeIcon = this.querySelector('svg.hidden');
                openIcon.classList.toggle('block');
                openIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('block');
                closeIcon.classList.toggle('hidden');
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>