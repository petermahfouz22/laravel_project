<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserManagementController extends Controller
{
    /**
     * Constructor - Apply admin middleware
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    /**
     * Manage users
     */
    public function users(Request $request)
    {
        $query = User::query();
        
        // Filter by role if provided
        if ($request->has('role') && in_array($request->role, ['admin', 'employer', 'candidate'])) {
            $query->where('role', $request->role);
        }
        
        // Search by name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->with('profile')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show user details
     */
    public function showUser(User $user)
    {
        // Load related data based on user role
        if ($user->role === 'employer') {
            $user->load(['companies', 'jobs']);
        } elseif ($user->role === 'candidate') {
            $user->load(['applications.job', 'resumes']);
        }
        
        return view('admin.users.show', compact('user'));
    }
    
    /**
     * Change user role
     */
    public function changeUserRole(Request $request, User $user)
    {
        // Validate request
        $validated = $request->validate([
            'role' => 'required|in:admin,employer,candidate',
        ]);
        
        // Prevent self-demotion
        if ($user->id === Auth::id() && $validated['role'] !== 'admin') {
            return redirect()->back()
                ->with('error', 'You cannot demote yourself from admin role.');
        }
        
        // Update role
        $user->role = $validated['role'];
        $user->save();
        
        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User role updated successfully.');
    }

    /**
     * Generate users report
     */
    public function usersReport($period = 'month')
    {
        // Define date range based on period
        $startDate = $this->getStartDateForPeriod($period);
        
        // Get users count by date
        $usersData = User::where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
            
        // Get users by role
        $roleData = User::where('created_at', '>=', $startDate)
            ->select(
                'role',
                DB::raw('count(*) as count')
            )
            ->groupBy('role')
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count', 'role')
            ->toArray();
            
        return [
            'timeSeriesData' => $usersData,
            'roleData' => $roleData,
        ];
    }
    
    /**
     * Get user registration stats by role
     */
    public function userRegistrationStats($days = 30)
    {
        $startDate = Carbon::now()->subDays($days);
        return User::where('created_at', '>=', $startDate)
            ->select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();
    }

    /**
     * Get start date based on period
     */
    private function getStartDateForPeriod($period)
    {
        switch ($period) {
            case 'week':
                return Carbon::now()->subDays(7);
            case 'month':
                return Carbon::now()->subDays(30);
            case 'quarter':
                return Carbon::now()->subMonths(3);
            case 'year':
                return Carbon::now()->subYear();
            default:
                return Carbon::now()->subDays(30);
        }
    }
}