<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;



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
Route::get('/users',[UserController::class,'index'])->name('admin.users.index');

Route::get('/users/show', function () {
    return view('admin.users.show');
})->name('admin.users.show');

Route::get('/addAdmin', function () {
    return view('admin.addAdmin');
})->name('addAdmin');

Route::get('/admin/users/{id}/editUser', [UserController::class, 'edit'])->name('editUser');




//!>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
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
//!>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
