<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Admin\JobController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/job', function () {
    return view('job_search');
})->name('job_search');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/jobShow', function () {
    return view('jobs.show');
})->name('jobs.show');

Route::get('/contact_us', function () {
    return view('contact us');
})->name('contact us');

Route::get('/job_category', function () {
    return view('job_category');
})->name('job_category');

Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/candidate', function () {
    return view('candidate.dashboard');
})->name('candidate');
//!>>>>>>>>>>>>>>>>>>>>>>>>>>Admin User Management Routes>>>>>>>>>>>>>>>>>>>>>>>>

Route::get('/users',[AdminController::class,'AdminIndexUser'])->name('admin.users.index');
Route::get('/users/show/{id}', [AdminController::class, 'AdminShowUser'])->name('admin.users.show');
Route::get('/admin/users/{id}/editUser', [AdminController::class, 'AdminEditUser'])->name('admin.users.edit');
Route::put('/admin/users/{id}/update', [AdminController::class, 'AdminUpdateUser'])->name('updateUser');
Route::delete('/admin/users/{id}', [AdminController::class, 'AdminDeleteUser'])->name('deleteUser');
Route::get('/admin/create', [AdminController::class, 'AdminCreateAdmin'])->name('createAdmin');
Route::post('/admin/create', [AdminController::class, 'AdminStoreAdmin'])->name('storeAdmin');



//!>>>>>>>>>>>>>>>>>>>>>>>>>>Admin Job Management Routes>>>>>>>>>>>>>>>>>>>>>>>>
Route::get('/jobs', [JobController::class, 'adminIndexJob'])->name('admin.jobs.index');


Route::middleware(['auth', 'admin'])->group(function () {
    // Route::get('/jobs', [JobController::class, 'adminJobsIndex'])->name('jobs');
    Route::get('/admin/jobs/pending', [JobController::class, 'adminJobs'])->name('admin.jobs.pending');
    Route::post('/admin/jobs/{id}/approve', [JobController::class, 'approve'])->name('admin.jobs.approve');
});



//!>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Socialite>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

//!Github
Route::get('/auth/github/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
});

//!Google
Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('google')->user();
});
//!Facebook
Route::get('/auth/facebook/redirect', function () {
    return Socialite::driver('facebook')->redirect();
})->name('facebook.redirect');

Route::get('/auth/facebook/callback', function () {
    $user = Socialite::driver('facebook')->user();
    // Handle the authenticated user (e.g., log them in)
    return redirect('/dashboard');
});
//!>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Middleware>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/admin/createAdmin', [AdminController::class, 'createAdmin'])->name('createAdmin');
    // Route::post('/admin/createAdmin', [AdminController::class, 'storeAdmin'])->name('createAdmin');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
