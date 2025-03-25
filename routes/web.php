<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Candidate\ApplicationController as CandidateApplicationController;
use App\Http\Controllers\Candidate\DashboardController as CandidateDashboardController;
use App\Http\Controllers\Candidate\JobController as CandidateJobController;
use App\Http\Controllers\Candidate\MessageController as CandidateMessageController;
use App\Http\Controllers\Candidate\ProfileController as CandidateProfileController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\Employer\EmployerJobController;
use App\Http\Controllers\Employer\ApplicantController;
use App\Http\Controllers\Employer\CompanyProfileController;
use App\Http\Controllers\Employer\InterviewController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SocialiteController;

Route::get('/', [HomeController::class, 'index'])->name('welcome');

// Login Routes (Unified)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Role Selection for Register
Route::get('/register', function () {
  \Log::info('Reached /register route', ['url' => request()->url()]);
  return view('auth.register-role-selection');
})->name('register');

Route::get('/register/{role}', function ($role) {
  \Log::info('Reached /register/{role} route', ['url' => request()->url(), 'role' => $role]);
  if (!in_array($role, ['candidate', 'employer'])) {
      abort(404);
  }
  return view('auth.register', ['role' => $role]);
})->name('register.form');



// Registration Routes
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
// Socialite Routes (from Admin Project)
// Socialite Routes

Route::get('/auth/{provider}/redirect/{role?}', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');
Route::get('/socialite/role-selection', [SocialiteController::class, 'showRoleSelection'])->name('socialite.role-selection');
Route::post('/socialite/role-selection', [SocialiteController::class, 'storeRoleSelection'])->name('socialite.role-selection.store');



Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
  // Dashboard
  Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

  // User Management
  Route::controller(AdminController::class)->group(function () {
      Route::get('/users', 'AdminIndexUser')->name('users.index');
      Route::get('/users/show/{id}', 'AdminShowUser')->name('users.show');
      Route::get('/users/{id}/edit', 'AdminEditUser')->name('users.edit');
      Route::put('/users/{id}/update', 'AdminUpdateUser')->name('users.update');
      Route::delete('/users/{id}', 'AdminDeleteUser')->name('users.delete');
      Route::get('/create', 'AdminCreateAdmin')->name('users.create');
      Route::post('/create', 'AdminStoreAdmin')->name('users.store');
  });

  // Job Management
    Route::controller(JobController::class)->group(function () {
      // Job Listing Routes
      Route::get('/jobs', 'adminIndexJob')->name('jobs.index');
      Route::get('/jobs/pending', 'adminJobs')->name('jobs.pending');
      
      // Individual Job Routes
      Route::get('/jobs/{slug}', 'show')->name('jobs.show');
      Route::get('/jobs/{id}/edit', 'edit')->name('jobs.edit');
      Route::put('/jobs/{id}', 'update')->name('jobs.update');
      
      // Job Approval and Deletion Routes
      Route::post('/jobs/{id}/approve', 'approve')->name('jobs.approve');
      Route::delete('/jobs/{id}', 'destroy')->name('jobs.destroy');
    
  });



});


Route::get('/jobs/{job}', [CandidateJobController::class, 'show'])->name('jobs.show');
Route::get('/jobs', [CandidateJobController::class, 'index'])->name('jobs.index');


    // Candidate Routes
    Route::middleware('role:candidate')->prefix('candidate')->name('candidate.')->group(function () {
      Route::get('/dashboard', [CandidateDashboardController::class, 'index'])->name('dashboard');
      Route::get('/profile', [CandidateProfileController::class, 'index'])->name('profile.index');
      Route::get('/profile/edit', [CandidateProfileController::class, 'edit'])->name('profile.edit');
      Route::post('/profile', [CandidateProfileController::class, 'update'])->name('profile.update');
      Route::get('/profile/resumes', [CandidateProfileController::class, 'resumes'])->name('profile.resumes');
      Route::post('/resume', [CandidateProfileController::class, 'storeResume'])->name('resume.store');
      Route::delete('/resume/{resume}', [CandidateProfileController::class, 'deleteResume'])->name('resume.delete');
      Route::get('/jobs/search', [CandidateJobController::class, 'search'])->name('jobs.search');
      Route::post('/jobs/{job}/save', [CandidateJobController::class, 'save'])->name('jobs.save');
      Route::get('/applications', [CandidateApplicationController::class, 'index'])->name('applications.index');
      Route::get('/applications/create/{job}', [CandidateApplicationController::class, 'create'])->name('applications.create');
      Route::post('/applications/store/{job}', [CandidateApplicationController::class, 'store'])->name('applications.store');
      Route::get('/messages', [CandidateMessageController::class, 'index'])->name('messages.index');
      Route::post('/messages', [CandidateMessageController::class, 'store'])->name('messages.store');
  });

  // Employer Routes
  Route::middleware('role:employer')->prefix('employer')->name('employer.')->group(function () {
      Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
      Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
      Route::resource('companies', CompanyProfileController::class);
      Route::resource('jobs', EmployerJobController::class);
      Route::put('/jobs/{job}/toggle-active', [EmployerJobController::class, 'toggleActive'])->name('jobs.toggle-active');
      Route::get('/jobs/{job}/applications', [ApplicantController::class, 'index'])->name('applications.index');
      Route::get('/jobs/{job}/applications/{application}', [ApplicantController::class, 'show'])->name('applications.show');
      Route::put('/jobs/{job}/applications/{application}/status', [ApplicantController::class, 'updateStatus'])->name('applications.update-status');
      Route::get('/jobs/{job}/applications/{application}/download-resume', [ApplicantController::class, 'downloadResume'])->name('applications.download-resume');
      Route::resource('interviews', InterviewController::class)->except(['create', 'store']);
      Route::get('/jobs/{job}/applications/{application}/interviews/create', [InterviewController::class, 'create'])->name('interviews.create');
      Route::post('/jobs/{job}/applications/{application}/interviews', [InterviewController::class, 'store'])->name('interviews.store');
      Route::put('/interviews/{interview}/complete', [InterviewController::class, 'markCompleted'])->name('interviews.complete');
  });

  // Profile Routes (shared across roles)
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  // Logout
  Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

