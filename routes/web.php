<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use Laravel\Socialite\Facades\Socialite;

// Redirect to GitHub
Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});

// Handle GitHub callback
Route::get('/auth/callback', function () {
    $githubUser = Socialite::driver('github')->user();

    // Find or create the user
    $user = User::firstOrCreate(
        ['email' => $githubUser->getEmail()],
        [
            'name' => $githubUser->getName(),
            'provider_id' => $githubUser->getId(),
            'provider' => 'github',
        ]
    );

    // Log in the user
    Auth::login($user);

    // Redirect to dashboard or home page
    return redirect('/dashboard');
});

// Google OAuth
Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    // Find or create the user
    $user = User::firstOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName(),
            'provider_id' => $googleUser->getId(),
            'provider' => 'google',
        ]
    );

    // Log in the user
    Auth::login($user);

    // Redirect to dashboard
    return redirect('/welcome');
});

// Facebook OAuth
Route::get('/auth/facebook/redirect', function () {
    return Socialite::driver('facebook')->redirect();
});

Route::get('/auth/facebook/callback', function () {
    $facebookUser = Socialite::driver('facebook')->user();

    // Find or create the user
    $user = User::firstOrCreate(
        ['email' => $facebookUser->getEmail()],
        [
            'name' => $facebookUser->getName(),
            'provider_id' => $facebookUser->getId(),
            'provider' => 'facebook',
        ]
    );

    // Log in the user
    Auth::login($user);

    // Redirect to dashboard
    return redirect('/dashboard');
});
require __DIR__.'/auth.php';
