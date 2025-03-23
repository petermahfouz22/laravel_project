@extends('layouts.admin')

@section('styles')
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
            margin-right: 15px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 120px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            right: 0;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown .dropbtn {
            text-decoration: none;
        }

        .dropdown:hover .dropbtn {
            background-color: #0056b3;
            color: white;
            border-color: #0056b3;
        }

        .icon-circle {
            height: 2.5rem;
            width: 2.5rem;
            border-radius: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 2px;
        }

        .activity-feed .feed-item {
            position: relative;
        }

        .activity-feed .feed-item:not(:last-child):after {
            content: '';
            position: absolute;
            left: 1.25rem;
            top: 2.5rem;
            bottom: -1rem;
            width: 2px;
            background-color: #e3e6f0;
        }

        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .chart-area {
            position: relative;
            height: 20rem;
        }

        .chart-pie {
            position: relative;
            height: 15rem;
        }
    </style>
@endsection

@section('content')

    <div class="container-fluid px-4 mt-14">

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Active Jobs Card -->
            <div
                class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-blue-500 hover:shadow-lg transition-shadow duration-300">
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs font-bold text-blue-600 uppercase tracking-wider">Active Jobs</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">25</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <i class="fas fa-briefcase text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-2 border-t">
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800 flex justify-end items-center">
                        View Details
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Total Employers Card -->
            <div
                class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-green-500 hover:shadow-lg transition-shadow duration-300">
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Total Employers</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">15</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <i class="fas fa-building text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-2 border-t">
                    <a href="#" class="text-sm text-green-600 hover:text-green-800 flex justify-end items-center">
                        View Details
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Registered Candidates Card -->
            <div
                class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-cyan-500 hover:shadow-lg transition-shadow duration-300">
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs font-bold text-cyan-600 uppercase tracking-wider">Registered Candidates</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">150</p>
                        </div>
                        <div class="p-3 bg-cyan-100 rounded-full">
                            <i class="fas fa-users text-cyan-500 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-2 border-t">
                    <a href="#" class="text-sm text-cyan-600 hover:text-cyan-800 flex justify-end items-center">
                        View Details
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Total Applications Card -->
            <div
                class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-amber-500 hover:shadow-lg transition-shadow duration-300">
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs font-bold text-amber-600 uppercase tracking-wider">Job Applications</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">85</p>
                        </div>
                        <div class="p-3 bg-amber-100 rounded-full">
                            <i class="fas fa-file-alt text-amber-500 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-2 border-t">
                    <a href="#" class="text-sm text-amber-600 hover:text-amber-800 flex justify-end items-center">
                        View Details
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Charts Section -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Line Chart - Job Applications Over Time -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Job Applications Over Time</h2>
                <div class="flex space-x-2">
                    <button
                        class="px-3 py-1 text-xs font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full">Week</button>
                    <button class="px-3 py-1 text-xs font-medium bg-indigo-100 text-indigo-700 rounded-full">Month</button>
                    <button
                        class="px-3 py-1 text-xs font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full">Year</button>
                </div>
            </div>
            <div class="p-6">
                <div class="h-64">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Pie Chart - Job Types Distribution -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Job Types Distribution</h2>
                <button class="text-sm text-indigo-600 hover:text-indigo-800">
                    <i class="fas fa-download"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="h-64">
                    <canvas id="pieChart"></canvas>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-3 h-3 rounded-full bg-indigo-500 mb-1"></div>
                        <span class="text-xs text-gray-600">Full-Time</span>
                        <span class="text-sm font-medium">50%</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-3 h-3 rounded-full bg-green-500 mb-1"></div>
                        <span class="text-xs text-gray-600">Part-Time</span>
                        <span class="text-sm font-medium">30%</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-3 h-3 rounded-full bg-blue-500 mb-1"></div>
                        <span class="text-xs text-gray-600">Freelance</span>
                        <span class="text-sm font-medium">20%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Line Chart Example
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [{
                    label: 'Applications',
                    data: [10, 20, 15, 25, 30],
                    borderColor: '#4e73df',
                    fill: false
                }]
            }
        });
        // Pie Chart Example
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Full-Time', 'Part-Time', 'Freelance'],
                datasets: [{
                    data: [50, 30, 20],
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc']
                }]
            }
        });
    </script>

@endsection