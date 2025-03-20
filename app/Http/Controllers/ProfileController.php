<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
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
        
        return view('profile.show', compact('user', 'profile'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile ?? new Profile();
        
        return view('profile.edit', compact('user', 'profile'));
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
    /**
     * Delete the user's profile.
     */public function destroy()
{
    $user = auth()->user();

    if ($user->profile) {
        // Delete profile image if exists
        if ($user->profile->profile_image) {
            Storage::delete('public/' . $user->profile->profile_image);
        }

        // Delete the profile
        $user->profile->delete();
    }

    return redirect()->route('welcome')->with('success', 'Profile deleted successfully');
}
}
