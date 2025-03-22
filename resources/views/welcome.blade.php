<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
</head>

<body class="font-poppins text-gray-700 leading-relaxed">
    <header
        class="bg-[linear-gradient(rgba(0,0,50,0.7),rgba(0,0,50,0.7)),url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f')] bg-cover bg-center h-screen flex flex-col justify-center items-center text-white text-center relative">
        @if (Route::has('login'))
            <nav class="absolute top-0 w-full px-6 md:px-12 py-5 bg-gray-900 bg-opacity-80">
                <div class="container mx-auto flex justify-between items-center">
                    <div class="text-2xl font-bold">JobFinder</div>
                    <ul class="hidden md:flex space-x-6">
                        <li><a href="{{ route('welcome') }}" class="text-white font-medium hover:underline">Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-white font-medium hover:underline">About</a></li>
                        <li><a href="{{ route('job_search') }}" class="text-white font-medium hover:underline">Discover Jobs</a></li>
                        <li><a href="{{ route('job_category')}}" class="text-white font-medium hover:underline">Jobs by Industry</a></li>
                        <li><a href="{{ route('contact_us') }}" class="text-white font-medium hover:underline">Contact Us</a></li>
                    </ul>

                    <div class="hidden md:flex space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-teal-500 text-white px-6 py-2 rounded-full font-medium hover:bg-teal-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-teal-500 text-white px-6 py-2 rounded-full font-medium hover:bg-teal-600">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="border-2 border-teal-500 text-teal-500 px-6 py-2 rounded-full font-medium hover:bg-teal-500 hover:text-white">Register</a>
                            @endif
                        @endauth
                    </div>

                    <button id="menu-toggle" class="md:hidden text-white focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <div id="mobile-menu"class="hidden md:hidden flex flex-col items-center w-full bg-gray-900 text-white p-5 space-y-4">
                    <a href="#" class="hover:underline">Home</a>
                    <a href="#" class="hover:underline">About</a>
                    <a href="#" class="hover:underline">Discover Jobs</a>
                    <a href="#" class="hover:underline">Jobs by Industry</a>
                    <a href="#" class="hover:underline">Contact Us</a>
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="bg-teal-500 text-white px-6 py-2 rounded-full font-medium hover:bg-teal-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-teal-500 text-white px-6 py-2 rounded-full font-medium hover:bg-teal-600">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="border-2 border-teal-500 text-teal-500 px-6 py-2 rounded-full font-medium hover:bg-teal-500 hover:text-white">Register</a>
                        @endif
                    @endauth
                </div>
            </nav>
        @endif
        <div class="hero-content px-4 md:px-0 max-w-4xl">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-5">Find Your Dream Job</h1>
            <p class="text-base sm:text-lg md:text-xl font-light mb-8">Connecting skilled professionals with leading
                companies</p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <button
                    class="bg-teal-500 text-white px-6 py-3 rounded-full font-medium hover:bg-teal-600 w-full sm:w-auto">Search
                    Jobs</button>
                <button
                    class="border-2 border-teal-500 text-teal-500 px-6 py-3 rounded-full font-medium hover:bg-teal-500 hover:text-white w-full sm:w-auto">Post
                    a Job</button>
            </div>
        </div>
    </header>
    <section class="py-12 bg-gray-100 text-center">
        <div class="max-w-3xl mx-auto flex flex-col space-y-4 px-4">
            <input type="text" placeholder="Job Title or Keywords" id="job-title"
                class="w-full p-3 border border-gray-300 rounded-md text-base focus:outline-none focus:ring-2 focus:ring-teal-500">
            <input type="text" placeholder="Location" id="location"
                class="w-full p-3 border border-gray-300 rounded-md text-base focus:outline-none focus:ring-2 focus:ring-teal-500">
            <button class="bg-teal-500 text-white px-8 py-3 rounded-md hover:bg-teal-600 w-full"
                onclick="searchJobs()">Search</button>
        </div>
    </section>
    <section class="py-12 text-center">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold mb-10">Featured Opportunities</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto px-4">
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-xl font-semibold mb-3">Software Engineer</h3>
                    <p class="text-sm text-gray-600 mb-2">TechCorp | Remote</p>
                    <p class="text-sm text-gray-600 mb-4">Build innovative solutions with a dynamic team.</p>
                    <a href="#"
                        class="inline-block bg-teal-500 text-white px-5 py-2 rounded-md hover:bg-teal-600 w-full">Apply
                        Now</a>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-xl font-semibold mb-3">Marketing Manager</h3>
                    <p class="text-sm text-gray-600 mb-2">GrowEasy | New York, NY</p>
                    <p class="text-sm text-gray-600 mb-4">Lead campaigns for a fast-growing startup.</p>
                    <a href="#"
                        class="inline-block bg-teal-500 text-white px-5 py-2 rounded-md hover:bg-teal-600 w-full">Apply
                        Now</a>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-xl font-semibold mb-3">UX Designer</h3>
                    <p class="text-sm text-gray-600 mb-2">DesignPro | San Francisco, CA</p>
                    <p class="text-sm text-gray-600 mb-4">Create user-friendly interfaces for top clients.</p>
                    <a href="#"
                        class="inline-block bg-teal-500 text-white px-5 py-2 rounded-md hover:bg-teal-600 w-full">Apply
                        Now</a>
                </div>
            </div>
        </div>
    </section>
    <div class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <h1 class="text-center mb-10 text-3xl font-bold">Job Listing</h1>
            <div class="text-center">
                <div class="overflow-x-auto">
                    <ul class="flex justify-center border-b mb-10 whitespace-nowrap">
                        <li class="mx-2 md:mx-3">
                            <a class="flex items-center text-start pb-3 border-b-2 border-blue-500 px-2" href="#tab-1">
                                <h6 class="mb-0 font-medium">Featured</h6>
                            </a>
                        </li>
                        <li class="mx-2 md:mx-3">
                            <a class="flex items-center text-start pb-3 hover:border-b-2 hover:border-blue-500 px-2"
                                href="#tab-2">
                                <h6 class="mb-0 font-medium">Full Time</h6>
                            </a>
                        </li>
                        <li class="mx-2 md:mx-3">
                            <a class="flex items-center text-start pb-3 hover:border-b-2 hover:border-blue-500 px-2"
                                href="#tab-3">
                                <h6 class="mb-0 font-medium">Part Time</h6>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane p-0 active">
                        <div class="p-4 mb-4 border rounded-lg shadow-sm">
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                                <div
                                    class="lg:col-span-8 flex flex-col sm:flex-row items-center text-center sm:text-left">
                                    <img class="w-20 h-20 border rounded object-cover mb-4 sm:mb-0"
                                        src="https://themewagon.github.io/jobentry/img/com-logo-1.jpg"
                                        alt="Company Logo">
                                    <div class="ps-0 sm:ps-4">
                                        <h5 class="mb-3 font-medium">Software Engineer</h5>
                                        <span class="mr-3 inline-block mb-2 sm:mb-0">New York, USA</span>
                                        <span class="mr-3 inline-block mb-2 sm:mb-0">Full Time</span>
                                        <span class="mr-0 inline-block">$123 - $456</span>
                                    </div>
                                </div>
                                <div class="lg:col-span-4 flex flex-col items-center lg:items-end justify-center">
                                    <div class="flex mb-3">
                                        <a class="bg-gray-100 p-2 rounded-md mr-3 text-blue-500" href="#">Save</a>
                                        <a class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md"
                                            href="#">Apply Now</a>
                                    </div>
                                    <small class="truncate">Date Line: 01 Jan, 2045</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-indigo-900 text-white py-8 text-center">
        <div class="container mx-auto px-4">
            <p>© 2025 JobFinder. All rights reserved.</p>
            <ul class="flex flex-wrap justify-center space-x-4 mt-3">
                <li><a href="#" class="text-white hover:underline py-1">About</a></li>
                <li><a href="#" class="text-white hover:underline py-1">Privacy Policy</a></li>
                <li><a href="#" class="text-white hover:underline py-1">Contact Us</a></li>
            </ul>
        </div>
    </footer>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        function searchJobs() {
            const jobTitle = document.getElementById('job-title').value;
            const location = document.getElementById('location').value;

            console.log('Searching for:', jobTitle, 'in', location);
            alert('Searching for: ' + jobTitle + ' in ' + location);
        }

        document.querySelectorAll('ul li a[href^="#tab-"]').forEach(tab => {
            tab.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelectorAll('ul li a').forEach(t => {
                    t.classList.remove('border-b-2', 'border-blue-500');
                    t.classList.add('hover:border-b-2', 'hover:border-blue-500');
                });

                this.classList.add('border-b-2', 'border-blue-500');
                this.classList.remove('hover:border-b-2', 'hover:border-blue-500');

                const tabId = this.getAttribute('href');
            });
        });
    </script>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>

</html>
