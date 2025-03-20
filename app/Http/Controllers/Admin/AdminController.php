<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Ensure you extend the base Controller
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function createAdmin()
    {
        return view('admin.createAdmin');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        // Create the new admin user
        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Ensure you have a 'role' column in your users table
        ]);

        // Handle profile image upload if provided
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $admin->profile_image = $imagePath;
            $admin->save();
        }

        return redirect()->route('admin.users.index')->with('success', 'Admin created successfully.');
    }
}