@extends('layouts.guest_main')

@section('styleJobCategoryShow')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        .category-card {
            background-color: white;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-color: #808080;
        }

        .category-icon {
            color: #808080;
            width: 64px;
            height: 64px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .category-icon svg {
            width: 100%;
            height: 100%;
        }

        .load-more-btn {
            background-color: #808080;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .load-more-btn:hover {
            background-color: #696969;
        }
    </style>
@endsection
@section('content')

    <div class="container mx-auto px-4 py-12 mt-14">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Jobs by Category</h2>
            <p class="text-gray-600 max-w-3xl mx-auto">Here you can browse the latest job listings related to your field and
                specialization</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Category 1: Construction Workers -->
            <div class="category-card p-6 text-center">
                <div class="category-icon mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="currentColor">
                        <path d="M32,4c-1.1,0-2,0.9-2,2v4h4V6C34,4.9,33.1,4,32,4z" />
                        <path d="M38,14H26c-1.1,0-2,0.9-2,2v4h16v-4C40,14.9,39.1,14,38,14z" />
                        <path d="M32,38c-3.3,0-6,2.7-6,6v16h12V44C38,40.7,35.3,38,32,38z" />
                        <path d="M44,24H20c-1.1,0-2,0.9-2,2v8h28v-8C46,24.9,45.1,24,44,24z" />
                        <path d="M46,38H18c-1.1,0-2,0.9-2,2v4h32v-4C48,38.9,47.1,38,46,38z" />
                    </svg>
                </div>
                <h3 class="font-medium text-lg text-gray-800 mb-1">Construction Workers</h3>
            </div>

            <!-- Category 2: Computer Specialist -->
            <div class="category-card p-6 text-center">
                <div class="category-icon mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="currentColor">
                        <path
                            d="M42,16H22c-1.1,0-2,0.9-2,2v20c0,1.1,0.9,2,2,2h20c1.1,0,2-0.9,2-2V18C44,16.9,43.1,16,42,16z" />
                        <path
                            d="M48,42H16c-1.1,0-2,0.9-2,2v2c0,1.1,0.9,2,2,2h32c1.1,0,2-0.9,2-2v-2C50,42.9,49.1,42,48,42z" />
                        <circle cx="46" cy="24" r="4" />
                    </svg>
                </div>
                <h3 class="font-medium text-lg text-gray-800 mb-1">Computer Specialist</h3>
            </div>

            <!-- Category 3: Sales -->
            <div class="category-card p-6 text-center">
                <div class="category-icon mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="currentColor">
                        <path
                            d="M42,16H22c-1.1,0-2,0.9-2,2v24c0,1.1,0.9,2,2,2h20c1.1,0,2-0.9,2-2V18C44,16.9,43.1,16,42,16z" />
                        <path
                            d="M48,46H16c-1.1,0-2,0.9-2,2v4c0,1.1,0.9,2,2,2h32c1.1,0,2-0.9,2-2v-4C50,46.9,49.1,46,48,46z" />
                        <path d="M36,8h-8c-1.1,0-2,0.9-2,2v4h12v-4C38,8.9,37.1,8,36,8z" />
                    </svg>
                </div>
                <h3 class="font-medium text-lg text-gray-800 mb-1">Sales</h3>
            </div>

            <!-- Category 4: Marketing -->
            <div class="category-card p-6 text-center">
                <div class="category-icon mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="currentColor">
                        <path
                            d="M44,24H20c-1.1,0-2,0.9-2,2v4c0,1.1,0.9,2,2,2h24c1.1,0,2-0.9,2-2v-4C46,24.9,45.1,24,44,24z" />
                        <path
                            d="M30,38H20c-1.1,0-2,0.9-2,2v4c0,1.1,0.9,2,2,2h10c1.1,0,2-0.9,2-2v-4C32,38.9,31.1,38,30,38z" />
                        <path
                            d="M44,38H34c-1.1,0-2,0.9-2,2v4c0,1.1,0.9,2,2,2h10c1.1,0,2-0.9,2-2v-4C46,38.9,45.1,38,44,38z" />
                        <path d="M48,8L32,14L16,8v8l16,6l16-6V8z" />
                    </svg>
                </div>
                <h3 class="font-medium text-lg text-gray-800 mb-1">Marketing</h3>
            </div>

            <!-- Category 5: Administrative Affairs -->
            <div class="category-card p-6 text-center">
                <div class="category-icon mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="currentColor">
                        <path d="M32,4c-4.4,0-8,3.6-8,8v4h16v-4C40,7.6,36.4,4,32,4z" />
                        <path d="M42,20H22c-1.1,0-2,0.9-2,2v6h24v-6C44,20.9,43.1,20,42,20z" />
                        <path d="M44,30H20v20c0,1.1,0.9,2,2,2h20c1.1,0,2-0.9,2-2V30z" />
                    </svg>
                </div>
                <h3 class="font-medium text-lg text-gray-800 mb-1">Administrative Affairs</h3>
            </div>

            <!-- Category 6: Technical -->
            <div class="category-card p-6 text-center">
                <div class="category-icon mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="currentColor">
                        <path d="M38,8H26c-1.1,0-2,0.9-2,2v12h16V10C40,8.9,39.1,8,38,8z" />
                        <path d="M24,24c-1.1,0-2,0.9-2,2v28c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V26c0-1.1-0.9-2-2-2H24z" />
                        <circle cx="48" cy="28" r="6" />
                    </svg>
                </div>
                <h3 class="font-medium text-lg text-gray-800 mb-1">Technical</h3>
            </div>

            <!-- Category 7: Higher Education -->
            <div class="category-card p-6 text-center">
                <div class="category-icon mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="currentColor">
                        <path d="M32,4L4,16l28,12l28-12L32,4z" />
                        <path d="M18,24v16c0,7.7,6.3,14,14,14s14-6.3,14-14V24l-14,6L18,24z" />
                        <path d="M52,20v16h4V20H52z" />
                    </svg>
                </div>
                <h3 class="font-medium text-lg text-gray-800 mb-1">Higher Education</h3>
            </div>

            <!-- Category 8: Other Jobs -->
            <div class="category-card p-6 text-center">
                <div class="category-icon mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="currentColor">
                        <circle cx="20" cy="32" r="4" />
                        <circle cx="32" cy="32" r="4" />
                        <circle cx="44" cy="32" r="4" />
                    </svg>
                </div>
                <h3 class="font-medium text-lg text-gray-800 mb-1">Other Jobs</h3>
            </div>
        </div>

        <div class="text-center mt-12">
            <button class="load-more-btn">Show More</button>
        </div>
    </div>
@endsection