<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the provider's authentication page.
     *
     * @param  string  $provider
     * @param  string|null  $role
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect($provider, $role = null)
    {
        // Store the role in the session to use after callback
        if ($role) {
            session(['socialite_role' => $role]);
        }
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the callback from the provider.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request, $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // Check if the user already exists
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // User exists, update provider fields if necessary
                if ($user->provider !== $provider) {
                    $user->update([
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                    ]);
                }
            } else {
                // New user, check if a role was provided
                $role = session('socialite_role');

                if (!$role) {
                    // No role provided, redirect to role selection
                    session(['socialite_user_data' => [
                        'email' => $socialUser->getEmail(),
                        'name' => $socialUser->getName() ?? 'User_' . Str::random(8),
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                    ]]);
                    return redirect()->route('socialite.role-selection');
                }

                // Create the user with the provided role
                $user = User::create([
                    'email' => $socialUser->getEmail(),
                    'name' => $socialUser->getName() ?? 'User_' . Str::random(8),
                    'password' => bcrypt(Str::random(16)),
                    'role' => $role,
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ]);
            }

            // Log the user in
            Auth::login($user, true);

            // Clear session data
            session()->forget('socialite_role');

            // Redirect based on role
            $route = match ($user->role) {
                'candidate' => 'candidate.dashboard',
                'employer' => 'employer.dashboard',
                'admin' => 'admin.dashboard',
                default => 'welcome',
            };

            return redirect()->route($route);
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['social_login' => 'Unable to login with ' . ucfirst($provider) . '. Please try again.']);
        }
    }

    /**
     * Display the role selection page for new Socialite users.
     *
     * @return \Illuminate\View\View
     */
    public function showRoleSelection()
    {
        if (!session('socialite_user_data')) {
            return redirect()->route('login');
        }
        return view('auth.socialite-role-selection');
    }

    /**
     * Store the selected role for a new Socialite user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRoleSelection(Request $request)
    {
        $request->validate([
            'role' => ['required', 'in:candidate,employer'],
        ]);

        $socialUserData = session('socialite_user_data');
        if (!$socialUserData) {
            return redirect()->route('login');
        }

        // Create the user with the selected role
        $user = User::create([
            'email' => $socialUserData['email'],
            'name' => $socialUserData['name'],
            'password' => bcrypt(Str::random(16)),
            'role' => $request->role,
            'provider' => $socialUserData['provider'],
            'provider_id' => $socialUserData['provider_id'],
        ]);

        // Log the user in
        Auth::login($user, true);

        // Clear session data
        session()->forget('socialite_user_data');

        // Redirect based on role
        $route = match ($user->role) {
            'candidate' => 'candidate.dashboard',
            'employer' => 'employer.dashboard',
            'admin' => 'admin.dashboard',
            default => 'welcome',
        };

        return redirect()->route($route);
    }
}