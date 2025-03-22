<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Candidate\ApplicationController as CandidateApplicationController;
use App\Http\Controllers\Candidate\DashboardController as CandidateDashboardController;
use App\Http\Controllers\Candidate\JobController as CandidateJobController;
use App\Http\Controllers\Candidate\MessageController as CandidateMessageController;
use App\Http\Controllers\Candidate\ProfileController as CandidateProfileController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
//employer controller
use App\Http\Controllers\Employer\DashboardController;
use App\Http\Controllers\Employer\EmployerJobController;
use App\Http\Controllers\Employer\ApplicantController;
use App\Http\Controllers\Employer\CompanyProfileController;
use App\Http\Controllers\Employer\InterviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('welcome');
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/jobs/{job}', [CandidateJobController::class, 'show'])->name('jobs.show'); // New show route
    Route::get('/jobs', [CandidateJobController::class, 'index'])->name('jobs.index');
    Route::post('/jobs/{job}/save', [CandidateJobController::class, 'save'])->name('jobs.save'); // New

});



    Route::middleware('auth')->group(function () {
    Route::middleware('role:candidate')->prefix('candidate')->name('candidate.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [CandidateDashboardController::class, 'index'])->name('dashboard');

        // Profile (Updated to ProfileController)
        Route::get('/profile', [CandidateProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [CandidateProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [CandidateProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/resumes', [CandidateProfileController::class, 'resumes'])->name('profile.resumes');
        Route::post('/resume', [CandidateProfileController::class, 'storeResume'])->name('resume.store');
        Route::delete('/resume/{resume}', [CandidateProfileController::class, 'deleteResume'])->name('resume.delete');

        // Jobs
        Route::get('/jobs', [CandidateJobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/search', [CandidateJobController::class, 'search'])->name('jobs.search');
        Route::get('/jobs/{job}', [CandidateJobController::class, 'show'])->name('jobs.show'); // New show route
        // Applications
        Route::get('/applications', [CandidateApplicationController::class, 'index'])->name('applications.index');
       // Show the application form (GET)
        Route::get('/candidate/applications/create/{job}', [CandidateApplicationController::class, 'create'])->name('applications.create');

        // Submit the application (POST)
        Route::post('/candidate/applications/store/{job}', [CandidateApplicationController::class, 'store'])->name('applications.store');
        // Messages
        Route::get('/messages', [CandidateMessageController::class, 'index'])->name('messages.index');
        Route::post('/messages', [CandidateMessageController::class, 'store'])->name('messages.store');
    });
    Route::middleware('role:employer')->prefix('employer')->name('employer.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Profile
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        
        // Company Profile Routes
        Route::resource('companies', CompanyProfileController::class);
        
        // Job management
        Route::resource('jobs', EmployerJobController::class);
        Route::put('/jobs/{job}/toggle-active', [EmployerJobController::class, 'toggleActive'])->name('jobs.toggle-active');
        
        // Application management
        Route::get('/jobs/{job}/applications', [ApplicantController::class, 'index'])->name('applications.index');
        Route::get('/jobs/{job}/applications/{application}', [ApplicantController::class, 'show'])->name('applications.show');
        Route::put('/jobs/{job}/applications/{application}/status', [ApplicantController::class, 'updateStatus'])->name('applications.update-status');
        Route::get('/jobs/{job}/applications/{application}/download-resume', [ApplicantController::class, 'downloadResume'])->name('applications.download-resume');
        
        // Interview management
        Route::resource('interviews', InterviewController::class)->except(['create', 'store']);
        Route::get('/jobs/{job}/applications/{application}/interviews/create', [InterviewController::class, 'create'])->name('interviews.create');
        Route::post('/jobs/{job}/applications/{application}/interviews', [InterviewController::class, 'store'])->name('interviews.store');
        Route::put('/interviews/{interview}/complete', [InterviewController::class, 'markCompleted'])->name('interviews.complete');
    });
    // Route::middleware('role:employer')->prefix('employer')->name('employer.')->group(function () {
    //     Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
    // });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});