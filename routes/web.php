<?php

use App\Http\Controllers\ProfileController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Employer\DashboardController;
use App\Http\Controllers\Employer\EmployerJobController;
use App\Http\Controllers\Employer\ApplicantController;
use App\Http\Controllers\Employer\CompanyProfileController;
use App\Http\Controllers\Employer\InterviewController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/job', function () {
    return view('job_search');
})->name('job_search');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/job_category', function () {
    return view('job_category');
})->name('job_category');

Route::get('/contact_us', function () {
    return view('contact_us');
})->name('contact_us');

Route::get('/jobs/show', function () {
    return view('jobs.show');
})->name('jobs.show');

// Authentication routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Social authentication routes
Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
    // $user->token
});

Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    $user = Socialite::driver('google')->user();
    // $user->token
});

// Employer routes
Route::middleware(['auth', \App\Http\Middleware\EmployerMiddleware::class])->prefix('employer')->name('employer.')->group(function () {
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

require __DIR__.'/auth.php';