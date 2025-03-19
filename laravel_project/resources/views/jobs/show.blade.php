@extends('layouts.guest_main')
@section('styleJobShow')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
  
  body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
        }
        
        .sidebar-section {
            background-color: white;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-title {
            color: #333;
            font-size: 18px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            margin-bottom: 10px;
        }
        
        .main-content {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .section-title {
            color: #333;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
            position: relative;
        }
        
        .section-title::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: #f6921e;
        }
        
        .form-control {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px 12px;
            width: 100%;
            margin-bottom: 16px;
        }
        
        .btn-primary {
            background-color: #f6921e;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #e58413;
        }
        
        .social-icons a {
            display: inline-block;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            text-align: center;
            line-height: 32px;
            margin-right: 8px;
            color: white;
        }
        
        .progress-bar {
            height: 6px;
            background-color: #eee;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 6px;
            margin-bottom: 16px;
        }
        
        .progress-bar-fill {
            height: 100%;
            background-color: #f6921e;
        }
    </style>
@endsection

@section('content')

    <div class="container mx-auto px-4 py-6 mt-14">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4">
                <!-- Share Section -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Share Article</h3>
                    <div class="social-icons mt-4">
                        <a href="#" style="background-color: #3b5998;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" style="background-color: #1da1f2;"><i class="fab fa-twitter"></i></a>
                        <a href="#" style="background-color: #25d366;"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" style="background-color: #0077b5;"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" style="background-color: #bd081c;"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                
                <!-- Related Posts -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Similar Jobs</h3>
                    <div class="mt-4">
                        <!-- Job listing item -->
                        <div class="border-b border-gray-200 pb-3 mb-3">
                            <h4 class="font-medium text-gray-800 mb-1">Accountant-KSA</h4>
                            <p class="text-sm text-gray-600 mb-2">
                                This is a dynamic role that requires a proactive and detail-oriented approach to accounting tasks.
                            </p>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>01/01/2025</span>
                                <a href="#" class="text-orange-500">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Popular Posts -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Popular Jobs</h3>
                    <div class="mt-4">
                        <!-- Job listing item -->
                        <div class="border-b border-gray-200 pb-3 mb-3">
                            <p class="text-sm text-gray-600 mb-2">
                                This is a position that requires in-depth knowledge of financial principles and practices
                            </p>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>01/01/2025</span>
                                <a href="#" class="text-orange-500">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tags -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Job Tags</h3>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="#" class="bg-gray-200 text-gray-700 text-xs rounded-full px-3 py-1">Accounting</a>
                        <a href="#" class="bg-gray-200 text-gray-700 text-xs rounded-full px-3 py-1">Finance</a>
                        <a href="#" class="bg-gray-200 text-gray-700 text-xs rounded-full px-3 py-1">Full-time</a>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <div class="main-content">
                    <!-- Job Details -->
                    <h2 class="section-title">Job Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="flex items-start">
                            <div class="mr-4">
                                <img src="https://via.placeholder.com/80" alt="Company Logo" class="w-20 h-20 object-contain border border-gray-200 rounded p-2">
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800">Company Name</h3>
                                <p class="text-sm text-gray-600">Brief company description</p>
                            </div>
                        </div>
                        
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Job Title:</span>
                                <span class="font-medium">Financial Accountant</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Job Type:</span>
                                <span class="font-medium">Full-time</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Location:</span>
                                <span class="font-medium">Riyadh, Saudi Arabia</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Published Date:</span>
                                <span class="font-medium">February 15, 2025</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Salary:</span>
                                <span class="font-medium">10,000 - 15,000 SAR</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Required Experience:</span>
                                <span class="font-medium">3-5 years</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Job Description -->
                    <h2 class="section-title mt-8">Job Description</h2>
                    <div class="mt-6 text-gray-700 space-y-4">
                        <p>We are looking for an experienced Financial Accountant to join our team in Riyadh. The ideal candidate has experience in financial reporting and account management.</p>
                        <p>The Financial Accountant role includes a variety of tasks including:</p>
                        <ul class="list-disc list-inside space-y-2">
                            <li>Preparing monthly, quarterly, and annual financial reports</li>
                            <li>Managing payments and receivables</li>
                            <li>Reconciling bank accounts and verifying financial data</li>
                            <li>Working on budgets and financial planning</li>
                            <li>Ensuring compliance with financial and tax regulations</li>
                        </ul>
                    </div>
                    
                    <!-- Requirements -->
                    <h2 class="section-title mt-8">Job Requirements</h2>
                    <div class="mt-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded">
                                <h4 class="font-medium text-gray-800 mb-2">Skills and Qualifications</h4>
                                <ul class="text-sm text-gray-700 space-y-2">
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        <span>Bachelor's degree in Accounting or Finance</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        <span>Minimum 3 years of experience in accounting</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        <span>Proficiency in accounting software</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded">
                                <h4 class="font-medium text-gray-800 mb-2">Personal Skills</h4>
                                <ul class="text-sm text-gray-700 space-y-2">
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        <span>Strong analytical skills</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        <span>Attention to detail</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        <span>Ability to work under pressure</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Skill Requirements -->
                    <h2 class="section-title mt-8">Job Skills</h2>
                    <div class="mt-6 space-y-4">
                        <div class="flex justify-between text-sm text-gray-700">
                            <span>Accounting Skills</span>
                            <span>90%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-bar-fill" style="width: 90%;"></div>
                        </div>
                        
                        <div class="flex justify-between text-sm text-gray-700">
                            <span>Accounting Software</span>
                            <span>85%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-bar-fill" style="width: 85%;"></div>
                        </div>
                        
                        <div class="flex justify-between text-sm text-gray-700">
                            <span>English Language</span>
                            <span>75%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-bar-fill" style="width: 75%;"></div>
                        </div>
                        
                        <div class="flex justify-between text-sm text-gray-700">
                            <span>Working Under Pressure</span>
                            <span>80%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-bar-fill" style="width: 80%;"></div>
                        </div>
                        
                        <div class="flex justify-between text-sm text-gray-700">
                            <span>Teamwork</span>
                            <span>95%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-bar-fill" style="width: 95%;"></div>
                        </div>
                    </div>
                    
                    <!-- Apply Button -->
                    <div class="mt-8 text-center">
                        <button class="btn-primary py-3 px-8 font-medium text-lg">Apply Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection