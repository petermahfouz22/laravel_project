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
    // public function index()
    // {
    //     // Verify admin access
    //     if (!auth()->user()->isAdmin()) {
    //         return redirect()->route('dashboard')->with('error', 'No permission ');
    //     }

    //     $users = User::latest()->paginate(10);
    //     return view('admin.users.index', compact('users'));
    // }
    // public function edit(User $user)
    // {
    //     // Verify access (admin or own profile)
    //     if (!auth()->user()->isAdmin() && auth()->id() !== $user->id) {
    //         return redirect()->route('dashboard')->with('error', 'No Permission');
    //     }
    
    //     return view('users.edit', compact('user'));
    // }

    public function index()
    {
        $users = User::paginate(10);
        $candidates = User::where('role', 'candidate')->paginate(10); // Fetch only candidates
        $employers = User::where('role', 'employer')->paginate(10); // Fetch only employers
        $admins = User::where('role', 'admin')->paginate(10);
        return view('admin.users.index',  compact('users', 'candidates','employers','admins'));
    }
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|min:8|confirmed',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('admin.users')->with('success', 'User updated successfully.');
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

    /**
     * Update the specified user in storage.
     */
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users,email,' . $id,
        // ]);
    
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
    
        return redirect()->route('admin.users.editUser')->with('success', 'User updated successfully.');
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