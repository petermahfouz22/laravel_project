<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller; // Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
//!>>>>>>>>>>>>>>>>>>>>>>>>>>>Index User>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    public function index()
    {
        $users = User::paginate(10);
        $candidates = User::where('role', 'candidate')->paginate(10); // Fetch only candidates

        $employers = User::where('role', 'employer')->paginate(10); // Fetch only employers
        $admins = User::where('role', 'admin')->paginate(10);
        return view('admin.users.index', compact('users', 'candidates', 'employers', 'admins'));
    }
    //!>>>>>>>>>>>>>>>>>>>>>>>>>>>Show User>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show', compact('user'));
    }
    //!>>>>>>>>>>>>>>>>>>>>>>>>>>>Update User>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.editUser', compact('user'));
    }

    public function updateUser(Request $request, $id)
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
    public function deleteUser($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $user->delete();
    
        return to_route('admin.users.index')->with('success', 'User deleted successfully');
    }
    //!>>>>>>>>>>>>>>>>>>>>>>>>>>Create User>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    public function createAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Not authorized');
        }

        return view('admin.users.create');
    }
    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'No Permission');
        }
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,employer,candidate',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Handle the image upload
        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        }
    
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'profile_image' => $imagePath,
        ]);
    
        return redirect()->route('admin.users.index')->with('success', 'Created successfully');
    }

//!>>>>>>>>>>>>>>>>>>>>>>>>>>Dashboards>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
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
//!>>>>>>>>>>>>>>>>>>>>>>>>>>adminDashboard>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    private function adminDashboard()
    {
        $totalUsers = User::count();
        $totalJobs = \App\Models\Job::count();
        $pendingJobs = \App\Models\Job::where('is_approved', false)->count();
        $totalEmployers = User::where('role', 'employer')->count();
        return view('admin.dashboard', compact('totalUsers', 'totalJobs', 'pendingJobs', 'pendingComments'));
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
}