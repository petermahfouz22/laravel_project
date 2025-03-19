
@extends('layouts.guest_main')
@section('content')
<div class="container mx-auto py-6 px-4 mt-14">
    <!-- Header with search -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex justify-between items-center">
                <div class="text-gray-500 text-sm">2402 Available Jobs</div>
                <div class="w-1/3">
                    <div class="relative">
                        <input type="text" placeholder="Keywords" class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-wrap -mx-3">
            <!-- Main content - job listings -->
            <div class="w-full lg:w-2/3 px-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Job Card 1 -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-bold">Sales Admin</h2>
                                    <div class="flex items-center text-sm text-gray-500 mt-1">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                        Cairo, New Cairo
                                    </div>
                                </div>
                                <div class="flex space-x-4">
                                    <div class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded">Full Time</div>
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <i class="far fa-bookmark"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center mt-3">
                                <img src="https://via.placeholder.com/40" alt="Company logo" class="w-10 h-10 rounded">
                            </div>
                            <p class="text-sm text-gray-600 mt-4 line-clamp-3">
                                LandReach Company for Corporate Establishment and Investment announces its need to hire for a Sales Admin position...
                            </p>
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center text-gray-500 text-xs">
                                    <i class="far fa-clock mr-1"></i>
                                    1 month ago
                                </div>
                                <div class="flex items-center text-gray-500 text-xs">
                                    <i class="fas fa-briefcase mr-1"></i>
                                    Sales
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Card 2 -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-bold">Accountant</h2>
                                    <div class="flex items-center text-sm text-gray-500 mt-1">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                        Cairo, New Cairo
                                    </div>
                                </div>
                                <div class="flex space-x-4">
                                    <div class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded">Full Time</div>
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <i class="far fa-bookmark"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center mt-3">
                                <img src="https://via.placeholder.com/40" alt="Company logo" class="w-10 h-10 rounded">
                            </div>
                            <p class="text-sm text-gray-600 mt-4 line-clamp-3">
                                LandReach Company for Corporate Establishment and Investment announces its need to hire for an Accountant position...
                            </p>
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center text-gray-500 text-xs">
                                    <i class="far fa-clock mr-1"></i>
                                    1 month ago
                                </div>
                                <div class="flex items-center text-gray-500 text-xs">
                                    <i class="fas fa-calculator mr-1"></i>
                                    Finance
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Card 3 -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-bold">HR Officer</h2>
                                    <div class="flex items-center text-sm text-gray-500 mt-1">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                        Giza, Dokki
                                    </div>
                                </div>
                                <div class="flex space-x-4">
                                    <div class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded">Full Time</div>
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <i class="far fa-bookmark"></i>
                                    </button>
            
                                </div>
                            </div>
                            <div class="flex items-center mt-3">
                                <img src="https://via.placeholder.com/40" alt="Company logo" class="w-10 h-10 rounded">
                            </div>
                            <p class="text-sm text-gray-600 mt-4 line-clamp-3">
                                International Trade and Mining Company is looking for immediate hiring for an "HR Officer" position...
                            </p>
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center text-gray-500 text-xs">
                                    <i class="far fa-clock mr-1"></i>
                                    1 month ago
                                </div>
                                <div class="flex items-center text-gray-500 text-xs">
                                    <i class="fas fa-users mr-1"></i>
                                    Administration
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Card 4 -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-bold">Sales Manager</h2>
                                    <div class="flex items-center text-sm text-gray-500 mt-1">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                        Cairo, New Cairo
                                    </div>
                                </div>
                                <div class="flex space-x-4">
                                    <div class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded">Full Time</div>
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <i class="far fa-bookmark"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center mt-3">
                                <img src="https://via.placeholder.com/40" alt="Company logo" class="w-10 h-10 rounded">
                            </div>
                            <p class="text-sm text-gray-600 mt-4 line-clamp-3">
                                LandReach Company for Corporate Establishment and Investment announces its need to hire for a Sales Manager position...
                            </p>
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center text-gray-500 text-xs">
                                    <i class="far fa-clock mr-1"></i>
                                    1 month ago
                                </div>
                                <div class="flex items-center text-gray-500 text-xs">
                                    <i class="fas fa-briefcase mr-1"></i>
                                    Sales
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar - filters -->
            <div class="w-full lg:w-1/3 px-3 mt-6 lg:mt-0">
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-bold mb-4">Filters</h3>
                    <hr class="mb-4">

                    <h4 class="font-semibold mb-3">Location</h4>
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="cairo" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label for="cairo" class="ml-2 text-sm">Cairo</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="giza" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label for="giza" class="ml-2 text-sm">Giza</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="6thOctober" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label for="6thOctober" class="ml-2 text-sm">6th of October</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="sheikhZayed" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label for="sheikhZayed" class="ml-2 text-sm">Sheikh Zayed</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="maadi" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label for="maadi" class="ml-2 text-sm">Maadi</label>
                        </div>
                    </div>

                    <button class="text-blue-600 text-sm mb-6">Show More</button>

                    <h4 class="font-semibold mb-3">Gender</h4>
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="male" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label for="male" class="ml-2 text-sm">Male</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="female" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label for="female" class="ml-2 text-sm">Female</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="both" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label for="both" class="ml-2 text-sm">Both Genders</label>
                        </div>
                    </div>
                    
                    <h4 class="font-semibold mb-3">Salary</h4>
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm">EGP 1,000</span>
                            <span class="text-sm">EGP 25,000</span>
                        </div>
                        <input type="range" min="1000" max="25000" value="15000" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        <div class="text-center mt-2 text-sm">
                            <span class="text-sm">EGP</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for interactive elements -->
    <script>
        // Bookmark toggle functionality
        document.querySelectorAll('.fa-bookmark').forEach(bookmark => {
            bookmark.addEventListener('click', function() {
                this.classList.toggle('far');
                this.classList.toggle('fas');
                if (this.classList.contains('fas')) {
                    this.classList.add('text-blue-500');
                } else {
                    this.classList.remove('text-blue-500');
                }
            });
        });

        // Filter show more functionality
        document.querySelector('button.text-blue-600').addEventListener('click', function() {
            // This would typically show more filter options
            // For demo purposes, we'll just log a message
            console.log('Show more filters clicked');
        });

        // Salary range slider functionality
        const rangeInput = document.querySelector('input[type="range"]');
        rangeInput.addEventListener('input', function() {
            const value = this.value;
            // Update some visual indicator or hidden field with the selected value
            console.log(`Salary range selected: ${value} EGP`);
        });
    </script>
@endsection