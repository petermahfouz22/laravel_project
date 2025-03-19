@extends('layouts.guest_main')

@section('content')


    <!-- Our Mission -->
    <section class="py-16 px-6 md:px-12 max-w-5xl mx-auto mt-10">
        <h2 class="text-3xl font-bold text-indigo-900 mb-6">Our Mission</h2>
        <p class="text-gray-600 leading-relaxed">At JobFinder, we're dedicated to connecting talented professionals with their ideal career opportunities. We believe everyone deserves meaningful work that aligns with their skills, values, and aspirations. Our platform serves as the bridge between ambitious job seekers and forward-thinking employers.</p>
    </section>

    <!-- Who We Are -->
    <section class="py-16 px-6 md:px-12 bg-white max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-8">
        <div class="md:w-1/2">
            <h2 class="text-3xl font-bold text-indigo-900 mb-6">Who We Are</h2>
            <p class="text-gray-600 leading-relaxed">Founded in 2023, JobFinder began with a simple observation: the traditional job search process was inefficient, frustrating, and often discouraging for both candidates and companies. Our team of HR professionals, tech innovators, and career coaches came together to create a more intelligent, personalized approach to job matching.</p>
        </div>
        <div class="md:w-1/2">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c" alt="Team collaborating" class="w-full rounded-lg shadow-md">
        </div>
    </section>

    <!-- How We're Different -->
    <section class="py-16 px-6 md:px-12 max-w-5xl mx-auto">
        <h2 class="text-3xl font-bold text-indigo-900 mb-8 text-center">How We're Different</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-teal-500 mb-3">Smart Matching Technology</h3>
                <p class="text-gray-600">Our proprietary algorithm analyzes not just skills and experience, but also workplace preferences, company culture fit, and career trajectory to suggest truly compatible matches.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-teal-500 mb-3">Comprehensive Resources</h3>
                <p class="text-gray-600">Beyond job listings, we provide career advice, resume building tools, interview preparation, and industry insights to help you succeed.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-teal-500 mb-3">Employer Verification</h3>
                <p class="text-gray-600">We carefully vet all companies on our platform to ensure legitimate opportunities and transparent hiring practices.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-teal-500 mb-3">Personalized Experience</h3>
                <p class="text-gray-600">Your JobFinder dashboard adapts to your preferences and search patterns, becoming more tailored to your needs over time.</p>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="py-16 px-6 md:px-12 bg-gray-100 max-w-5xl mx-auto">
        <h2 class="text-3xl font-bold text-indigo-900 mb-8 text-center">Our Values</h2>
        <ul class="space-y-4">
            <li class="flex items-start">
                <span class="text-teal-500 font-bold mr-2">• Transparency:</span>
                <span class="text-gray-600">We believe in clear communication and honest representation of opportunities.</span>
            </li>
            <li class="flex items-start">
                <span class="text-teal-500 font-bold mr-2">• Inclusivity:</span>
                <span class="text-gray-600">We're committed to creating equal access to opportunities for people of all backgrounds.</span>
            </li>
            <li class="flex items-start">
                <span class="text-teal-500 font-bold mr-2">• Innovation:</span>
                <span class="text-gray-600">We continuously improve our platform based on user feedback and emerging technologies.</span>
            </li>
            <li class="flex items-start">
                <span class="text-teal-500 font-bold mr-2">• Support:</span>
                <span class="text-gray-600">We provide guidance at every step of your career journey.</span>
            </li>
        </ul>
    </section>

    <!-- Join Our Community -->
    <section class="py-16 px-6 md:px-12 text-center bg-teal-500 text-white">
        <h2 class="text-3xl font-bold mb-4">Join Our Community</h2>
        <p class="text-lg max-w-2xl mx-auto mb-6">Whether you're actively searching for a new position, exploring potential career paths, or looking to hire exceptional talent, JobFinder is your trusted partner in navigating the professional landscape.</p>
        <p class="text-xl font-semibold italic mb-6">Start your journey with JobFinder today and discover where your skills can take you.</p>
        <a href="#" class="inline-block bg-white text-teal-500 px-8 py-3 rounded-full font-medium hover:bg-gray-100">Get Started</a>
    </section>
@endsection