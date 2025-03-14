<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     * Admin access only.
     */
    public function index()
    {
        // Verify admin access
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'No permission ');
        }

        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     * Admin access only.
     */
    public function create()
    {
        // Verify admin access
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Not authorized');
        }

        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     * Admin access only.
     */
    public function store(Request $request)
    {
        // Verify admin access
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'No Permission');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,employer,candidate',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Created successfully');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        // Verify access (admin or own profile)
        if (!auth()->user()->isAdmin() && auth()->id() !== $user->id) {
            return redirect()->route('dashboard')->with('error', 'No permission');
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // Verify access (admin or own profile)
        if (!auth()->user()->isAdmin() && auth()->id() !== $user->id) {
            return redirect()->route('dashboard')->with('error', 'No Permission');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // Verify access (admin or own profile)
        if (!auth()->user()->isAdmin() && auth()->id() !== $user->id) {
            return redirect()->route('dashboard')->with('error', 'No Permission');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Only admin can change roles
        if (auth()->user()->isAdmin() && $request->has('role')) {
            $validated['role'] = $request->validate([
                'role' => 'required|in:admin,employer,candidate',
            ])['role'];
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (isset($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        if (isset($validated['role'])) {
            $user->role = $validated['role'];
        }
        
        $user->save();

        return redirect()->route('users.show', $user)->with('success', 'Update the user successfully');
    }

    /**
     * Remove the specified user from storage.
     * Admin access only.
     */
    public function destroy(User $user)
    {
        // Verify admin access
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'No Permission');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User Deleted Successfully');
    }

    /**
     * Display the user dashboard.
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        // Redirect to appropriate dashboard based on user role
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isEmployer()) {
            return $this->employerDashboard();
        } else {
            return $this->candidateDashboard();
        }
    }

    /**
     * Display the admin dashboard.
     */
    private function adminDashboard()
    {
        // Get stats for admin dashboard
        $totalUsers = User::count();
        $totalJobs = \App\Models\Job::count();
        $pendingJobs = \App\Models\Job::where('is_approved', false)->count();
        $pendingComments = \App\Models\Comment::where('is_approved', false)->count();
        
        return view('admin.dashboard', compact('totalUsers', 'totalJobs', 'pendingJobs', 'pendingComments'));
    }

    /**
     * Display the employer dashboard.
     */
    private function employerDashboard()
    {
        $user = auth()->user();
        $jobs = $user->postedJobs()->latest()->paginate(5);
        $totalApplications = \App\Models\Application::whereIn('job_id', $user->postedJobs()->pluck('id'))->count();
        
        return view('employer.dashboard', compact('jobs', 'totalApplications'));
    }

    /**
     * Display the candidate dashboard.
     */
    private function candidateDashboard()
    {
        $user = auth()->user();
        $applications = $user->applications()->with('job')->latest()->paginate(5);
        $savedJobs = $user->savedJobs ?? collect();
        
        return view('candidate.dashboard', compact('applications', 'savedJobs'));
    }
}