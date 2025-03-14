<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\Comment;
use App\Models\Technology;
use App\Models\FeaturedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Constructor - Apply admin middleware
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    /**
     * Display admin dashboard with statistics
     */
    public function dashboard()
    {
        // Get counts for dashboard cards
        $stats = [
            'totalUsers' => User::count(),
            'totalJobs' => Job::count(),
            'activeJobs' => Job::where('is_active', true)->where('is_approved', true)->count(),
            'pendingJobs' => Job::where('is_approved', false)->count(),
            'totalApplications' => Application::count(),
            'totalCompanies' => Company::count(),
            'totalCategories' => JobCategory::count(),
        ];
        
        // Get user registration stats by role (last 30 days)
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $userStats = User::where('created_at', '>=', $thirtyDaysAgo)
            ->select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();
        
        // Get job stats (last 30 days)
        $recentJobs = Job::where('created_at', '>=', $thirtyDaysAgo)->count();
        
        // Get application stats by status
        $applicationStats = Application::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        // Get most active job categories
        $popularCategories = JobCategory::withCount('jobs')
            ->orderBy('jobs_count', 'desc')
            ->take(5)
            ->get();
        
        // Recent activity (jobs, applications)
        $recentActivity = collect();
        
        // Add recent jobs
        $recentJobs = Job::with(['company', 'employer'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($job) {
                return [
                    'type' => 'job',
                    'data' => $job,
                    'date' => $job->created_at,
                ];
            });
        
        // Add recent applications
        $recentApplications = Application::with(['job', 'candidate'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($application) {
                return [
                    'type' => 'application',
                    'data' => $application,
                    'date' => $application->created_at,
                ];
            });
        
        // Merge and sort by date
        $recentActivity = $recentJobs->concat($recentApplications)
            ->sortByDesc('date')
            ->take(10);
        
        return view('admin.dashboard', compact(
            'stats', 
            'userStats', 
            'recentJobs', 
            'applicationStats', 
            'popularCategories', 
            'recentActivity'
        ));
    }
    
    /**
     * Manage pending job approvals
     */
    public function pendingJobs()
    {
        $pendingJobs = Job::where('is_approved', false)
            ->with(['company', 'employer', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.jobs.pending', compact('pendingJobs'));
    }
    
    /**
     * Approve a job
     */
    public function approveJob(Job $job)
    {
        $job->is_approved = true;
        $job->save();
        
        // Notification logic could be added here
        
        return redirect()->back()
            ->with('success', 'Job approved successfully.');
    }
    
    /**
     * Reject a job with reason
     */
    public function rejectJob(Request $request, Job $job)
    {
        $validated = $request->validate([
            'reason' => 'required|string|min:10',
        ]);
        
        // Set job as rejected
        $job->is_approved = false;
        $job->is_active = false;
        $job->save();
        
        // Notification logic with reason could be added here
        
        return redirect()->back()
            ->with('success', 'Job has been rejected.');
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
     * Manage featured jobs
     */
    public function featuredJobs()
    {
        $featuredJobs = FeaturedJob::with(['job.company'])
            ->orderBy('priority', 'desc')
            ->paginate(10);
            
        return view('admin.featured-jobs.index', compact('featuredJobs'));
    }
    
    /**
     * Show form to add featured job
     */
    public function createFeaturedJob()
    {
        // Get active and approved jobs not already featured
        $availableJobs = Job::where('is_active', true)
            ->where('is_approved', true)
            ->whereDoesntHave('featuredJob')
            ->with('company')
            ->get();
            
        return view('admin.featured-jobs.create', compact('availableJobs'));
    }
    
    /**
     * Store a new featured job
     */
    public function storeFeaturedJob(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'priority' => 'required|integer|min:0|max:100',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);
        
        // Check if job is already featured
        if (FeaturedJob::where('job_id', $validated['job_id'])->exists()) {
            return redirect()->back()
                ->with('error', 'This job is already featured.');
        }
        
        // Create featured job
        $featuredJob = new FeaturedJob();
        $featuredJob->job_id = $validated['job_id'];
        $featuredJob->priority = $validated['priority'];
        $featuredJob->start_date = $validated['start_date'];
        $featuredJob->end_date = $validated['end_date'];
        $featuredJob->save();
        
        return redirect()->route('admin.featured-jobs')
            ->with('success', 'Job featured successfully.');
    }
    
    /**
     * Remove a job from featured
     */
    public function removeFeaturedJob(FeaturedJob $featuredJob)
    {
        $featuredJob->delete();
        
        return redirect()->route('admin.featured-jobs')
            ->with('success', 'Job removed from featured list.');
    }
    
    /**
     * Manage pending comments
     */
    public function pendingComments()
    {
        $pendingComments = Comment::where('is_approved', false)
            ->with(['commentable', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.comments.pending', compact('pendingComments'));
    }
    
    /**
     * System settings page
     */
    public function settings()
    {
        // Get all settings (you would need a settings table/model)
        // For now we'll just return the view
        return view('admin.settings');
    }
    
    /**
     * Update system settings
     */
    public function updateSettings(Request $request)
    {
        // Validate and save settings
        // Implementation would depend on your settings structure
        
        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully.');
    }
    
    /**
     * Generate system reports
     */
    public function reports(Request $request)
    {
        $reportType = $request->type ?? 'jobs';
        $period = $request->period ?? 'month';
        
        $data = [];
        
        switch ($reportType) {
            case 'jobs':
                $data = $this->generateJobsReport($period);
                break;
            case 'applications':
                $data = $this->generateApplicationsReport($period);
                break;
            case 'users':
                $data = $this->generateUsersReport($period);
                break;
        }
        
        return view('admin.reports', compact('reportType', 'period', 'data'));
    }
    
    /**
     * Generate jobs report
     */
    private function generateJobsReport($period)
    {
        // Define date range based on period
        $startDate = $this->getStartDateForPeriod($period);
        
        // Get jobs count by date
        $jobsData = Job::where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
            
        // Get jobs by category
        $categoryData = Job::where('created_at', '>=', $startDate)
            ->join('job_categories', 'jobs.category_id', '=', 'job_categories.id')
            ->select(
                'job_categories.name',
                DB::raw('count(*) as count')
            )
            ->groupBy('job_categories.name')
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count', 'name')
            ->toArray();
            
        return [
            'timeSeriesData' => $jobsData,
            'categoryData' => $categoryData,
        ];
    }
    
    /**
     * Generate applications report
     */
    private function generateApplicationsReport($period)
    {
        // Define date range based on period
        $startDate = $this->getStartDateForPeriod($period);
        
        // Get applications count by date
        $applicationsData = Application::where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
            
        // Get applications by status
        $statusData = Application::where('created_at', '>=', $startDate)
            ->select(
                'status',
                DB::raw('count(*) as count')
            )
            ->groupBy('status')
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
            
        return [
            'timeSeriesData' => $applicationsData,
            'statusData' => $statusData,
        ];
    }
    
    /**
     * Generate users report
     */
    private function generateUsersReport($period)
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