<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Ensure you extend the base Controller
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function AdminCreateAdmin()
    {
        return view('admin.createAdmin');
    }

    public function AdminStoreAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'profile_image' => 'nullable|image|mimes:jpg,png,gif|max:2048',
        ]);

        // Create the new admin user
        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        // Handle profile image upload if provided
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $admin->profile_image = $imagePath;
            $admin->save();
        }

        return redirect()->route('admin.users.index')->with('success', 'Admin created successfully.');
    }

    //!>>>>>>>>>>>>>>>>>>>>>>>>>>>Index User>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    public function AdminIndexUser()
    {
        $users = User::paginate(10);
        $candidates = User::where('role', 'candidate')->paginate(10); // Fetch only candidates

        $employers = User::where('role', 'employer')->paginate(10); // Fetch only employers
        $admins = User::where('role', 'admin')->paginate(10);
        return view('admin.users.index', compact('users', 'candidates', 'employers', 'admins'));
    }
    //!>>>>>>>>>>>>>>>>>>>>>>>>>>>Show User>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    public function AdminShowUser($id)
    {
        $user = User::find($id);
        return view('admin.users.show', compact('user'));
    }
    //!>>>>>>>>>>>>>>>>>>>>>>>>>>>Update User>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    public function AdminEditUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.editUser', compact('user'));
    }

    public function AdminUpdateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }
    //!>>>>>>>>>>>>>>>>>>>>>>>>>>Delete User>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    public function AdminDeleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return to_route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
