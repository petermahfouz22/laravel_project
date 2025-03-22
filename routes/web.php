<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Candidate\ApplicationController as CandidateApplicationController;
use App\Http\Controllers\Candidate\DashboardController as CandidateDashboardController;
use App\Http\Controllers\Candidate\JobController as CandidateJobController;
use App\Http\Controllers\Candidate\MessageController as CandidateMessageController;
use App\Http\Controllers\Candidate\ProfileController as CandidateProfileController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;

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
        Route::post('/profile', [CandidateProfileController::class, 'update'])->name('profile.update');
        Route::post('/resume', [CandidateProfileController::class, 'storeResume'])->name('resume.store');

        // Jobs
        Route::get('/jobs', [CandidateJobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/search', [CandidateJobController::class, 'search'])->name('jobs.search');
        Route::get('/jobs/{job}', [CandidateJobController::class, 'show'])->name('jobs.show'); // New show route
        // Applications
        Route::get('/applications', [CandidateApplicationController::class, 'index'])->name('applications.index');
       // Show the application form (GET)
Route::get('/candidate/applications/create/{job}', [CandidateApplicationController::class, 'create'])->name('candidate.applications.create');

// Submit the application (POST)
Route::post('/candidate/applications/store/{job}', [CandidateApplicationController::class, 'store'])->name('candidate.applications.store');
        // Messages
        Route::get('/messages', [CandidateMessageController::class, 'index'])->name('messages.index');
        Route::post('/messages', [CandidateMessageController::class, 'store'])->name('messages.store');
    });

    // Route::middleware('role:employer')->prefix('employer')->name('employer.')->group(function () {
    //     Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
    // });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});