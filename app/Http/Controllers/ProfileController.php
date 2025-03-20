<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
=======
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
>>>>>>> a8ef134669f78db1c3426dba217de3914161e0ee

class ProfileController extends Controller
{
    /**
<<<<<<< HEAD
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
=======
     * Display the user's profile.
     */
    public function show($userId = null)
    {
        $user = $userId ? User::findOrFail($userId) : auth()->user();
        
        // Check if the profile viewing is public or belongs to the authenticated user
        if ($userId && auth()->id() !== $user->id && !$user->profile?->public) {
            return redirect()->route('dashboard')->with('error', 'THis profile personally not puplic');
        }
        
        $profile = $user->profile ?? new Profile();
        
        return view('profiles.show', compact('user', 'profile'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile ?? new Profile();
        
        return view('profiles.edit', compact('user', 'profile'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        // Validate the request
        $validated = $request->validate([
            'bio' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|max:2048', // max 2MB
            'linkedin_url' => 'nullable|url|max:255',
            'website' => 'nullable|url|max:255',
        ]);
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile && $user->profile->profile_image) {
                Storage::delete('public/' . $user->profile->profile_image);
            }
            
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $validated['profile_image'] = $path;
        }
        
        // Create or update profile
        if ($user->profile) {
            $user->profile->update($validated);
        } else {
            $user->profile()->create($validated);
        }
        
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }
    
    /**
     * Import profile data from LinkedIn.
     * This is a bonus feature.
     */
    public function importFromLinkedIn(Request $request)
    {
        // This would require LinkedIn API integration
        // Placeholder for bonus feature
        
        return redirect()->route('profile.edit')->with('info', ' For the purpose of importing data from LinkedIn is under development.');
    }
    
    /**
     * Remove the profile picture.
     */
    public function removeProfilePicture()
    {
        $user = auth()->user();
        
        if ($user->profile && $user->profile->profile_image) {
            Storage::delete('public/' . $user->profile->profile_image);
            $user->profile->update(['profile_image' => null]);
        }
        
        return redirect()->route('profile.edit')->with('success', 'Delete your picture profile successfully');
    }
}
>>>>>>> a8ef134669f78db1c3426dba217de3914161e0ee
