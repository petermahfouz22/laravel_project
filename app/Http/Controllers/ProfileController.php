<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

  public function show(User $user)
    {
        // Ensure the user is a candidate
        if ($user->role !== 'candidate') {
            abort(403, 'Unauthorized access');
        }

        // Optional: Add authorization check
        // Ensure only the user themselves or an admin can view the full profile
        if (Auth::user()->id !== $user->id && Auth::user()->role !== 'admin') {
            abort(403, 'You are not authorized to view this profile');
        }

        // Load profile relationship if not already loaded
        $user->load('profile');

        return view('candidate.profile', [
            'user' => $user,
            'profile' => $user->profile
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile ?? $user->profile()->create([]);
        
        // Array of available roles for dropdown
        $roles = [
            'admin' => 'Admin',
            'employer' => 'Employer',
            'candidate' => 'Candidate'
        ];
        
        return view('profile.edit', compact('user', 'profile', 'roles'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role' => 'required|string|in:admin,employer,candidate',
            'bio' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'linkedin_url' => 'nullable|url|max:255',
            'website' => 'nullable|url|max:255',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        // Update user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, // Update the user's role
        ]);

        // Get or create profile
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($profile->profile_image) {
                Storage::disk('public')->delete($profile->profile_image);
            }
            
            $imagePath = $request->file('profile_image')->store('profile-images', 'public');
            $profile->profile_image = $imagePath;
        }
        
        // Update other profile fields
        $profile->bio = $request->bio;
        $profile->location = $request->location;
        $profile->phone = $request->phone;
        $profile->linkedin_url = $request->linkedin_url;
        $profile->website = $request->website;
        
        // Save profile
        $profile->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Delete the user's profile and account.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request
        $request->validate([
            'password' => 'required|current_password',
        ]);
        
        // Delete profile image if it exists
        if ($user->profile && $user->profile->profile_image) {
            Storage::disk('public')->delete($user->profile->profile_image);
        }
        
        // Delete profile
        if ($user->profile) {
            $user->profile->delete();
        }
        
        // Delete the user
        $user->delete();
        
        // Log the user out
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }
}