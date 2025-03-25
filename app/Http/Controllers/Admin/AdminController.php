<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Ensure you extend the base Controller
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
        $candidates = User::where('role', 'candidate')->paginate(10); 
        $employers = User::where('role', 'employer')->paginate(10);
        $admins = User::where('role', 'admin')->paginate(10);
        
        return view('admin.users.index', compact('users', 'candidates', 'employers', 'admins'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isEmployer()) {
            return $this->employerDashboard();
        } else {
            return $this->candidateDashboard();
        }
    }

    private function adminDashboard()
    {
        $totalUsers = User::count();
        $totalJobs = \App\Models\Job::count();
        $pendingJobs = \App\Models\Job::where('is_approved', false)->count();
        $totalEmployers = User::where('role', 'employer')->count();
        return view('admin.dashboard', compact('totalUsers', 'totalJobs', 'pendingJobs'));
    }
    //!>>>>>>>>>>>>>>>>>>>>>>>>>>employerDashboard>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    private function employerDashboard()
    {
        $user = auth()->user();
        $jobs = $user->postedJobs()->latest()->paginate(5);
        $totalApplications = \App\Models\Application::whereIn('job_id', $user->postedJobs()->pluck('id'))->count();

        return view('employer.dashboard', compact('jobs', 'totalApplications'));
    }
    //!>>>>>>>>>>>>>>>>>>>>>>>>>>candidateDashboard>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    private function candidateDashboard()
    {
        $user = auth()->user();
        $applications = $user->applications()->with('job')->latest()->paginate(5);
        $savedJobs = $user->savedJobs ?? collect();

        return view('candidate.dashboard', compact('applications', 'savedJobs'));
    }

//!>>>>>
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

    // Validate common fields
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        'role' => 'required|in:candidate,employer,admin',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Add profile image validation
    ]);

    // Update common user details
    $user->name = $validated['name'];
    $user->email = $validated['email'];

    // Handle profile image upload
    if ($request->hasFile('profile_image')) {
        // Delete old profile image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Store new profile image
        $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        $user->profile_image = $imagePath;
    }

    // If role is changing, handle role-specific logic
    if ($user->role !== $request->input('role')) {
        $user->role = $request->input('role');
    }

    // Role-specific updates
    switch ($request->input('role')) {
        case 'admin':
            $request->validate([
                'admin_level' => 'required|in:super_admin,content_admin,user_admin'
            ]);
            $user->admin_level = $request->input('admin_level');
            break;

        case 'employer':
            $request->validate([
                'company_name' => 'nullable|string|max:255'
            ]);
            
            // Update or create company profile
            $company = $user->company ?? new \App\Models\Company();
            $company->name = $request->input('company_name');
            $company->user_id = $user->id;
            $company->save();
            break;

        case 'candidate':
            $request->validate([
                'skills' => 'nullable|string',
                'job_preferences' => 'nullable|string'
            ]);
            
            // Update or create candidate profile
            $candidate = $user->candidate ?? new \App\Models\Candidate();
            $candidate->skills = $request->input('skills');
            $candidate->job_preferences = $request->input('job_preferences');
            $candidate->user_id = $user->id;
            $candidate->save();
            break;
    }

    $user->save();

    return redirect()->route('admin.users.index')
        ->with('success', 'User updated successfully');
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
