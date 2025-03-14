<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;


Route::get('/', function () {
    return view('welcome');
})-> name('welcome');

Route::get('/job', function () {
  return view('job_search');
})->name('job_search');

Route::get('/about', function () {
  return view('about');
})->name('about');

Route::get('/jobShow', function () {
  return view('jobs.show');
})->name('jobs.show');

Route::get('/job_category', function () {
  return view('job_category');
})->name('job_category');

Route::get('/contact_us', function () {
  return view('contact us');
})->name('contact us');

Route::get('/jobs/show', function () {
  return view('jobs.show');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//github routes
Route::get('/auth/redirect', function () {
  return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {
  $user = Socialite::driver('github')->user();

  // $user->token
});


// google routes
Route::get('/auth/google/redirect', function () {
  return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
  $user = Socialite::driver('google')->user();

  // $user->token
});
require __DIR__.'/auth.php';
