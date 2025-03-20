<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\Comment;
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
    // public function __construct()
    // {
    //     $this->middleware('admin');
    // }

    /**
     * Display admin dashboard with statistics
     */
    public function dashboard()
    {
        // Get counts for dashboard cards
        $stats = $this->getDashboardStats();

        // Get registration stats (last 30 days)
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $userStats = $this->getUserStats($thirtyDaysAgo);

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

        // Get recent activity
        $recentActivity = $this->getRecentActivity();

        return view('admin.dashboard', compact(
            'stats',
            'userStats',
            'applicationStats',
            'popularCategories',
            'recentActivity'
        ));
    }

    /**
     * Collect dashboard statistics
     */
    private function getDashboardStats()
    {
        return [
            'totalUsers' => User::count(),
            'totalJobs' => Job::count(),
            'activeJobs' => Job::where('is_active', true)->where('is_approved', true)->count(),
            'pendingJobs' => Job::where('is_approved', false)->count(),
            'totalApplications' => Application::count(),
            'totalCompanies' => Company::count(),
            'totalCategories' => JobCategory::count(),
        ];
    }

    /**
     * Get user statistics
     */
    private function getUserStats($fromDate)
    {
        return User::where('created_at', '>=', $fromDate)
            ->select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();
    }

    /**
     * Get recent activity items
     */
    private function getRecentActivity()
    {
        // Add recent jobs
        $recentJobs = Job::with(['company', 'employer'])
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($job) => [
                'type' => 'job',
                'data' => $job,
                'date' => $job->created_at,
            ]);

        // Add recent applications
        $recentApplications = Application::with(['job', 'candidate'])
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($application) => [
                'type' => 'application',
                'data' => $application,
                'date' => $application->created_at,
            ]);

        // Merge and sort by date
        return $recentJobs->concat($recentApplications)
            ->sortByDesc('date')
            ->take(10);
    }

    /**
     * Manage pending job approvals
     */
    public function pendingJobs()
    {
        $pendingJobs = Job::where('is_approved', false)
            ->with(['company', 'employer', 'category'])
            ->latest()
            ->paginate(10);

        return view('admin.jobs.pending', compact('pendingJobs'));
    }

    /**
     * Approve a job
     */
    public function approveJob(Job $job)
    {
        $job->update(['is_approved' => true]);

        // Notification logic could be added here

        return redirect()->back()->with('success', 'Job approved successfully.');
    }

    /**
     * Reject a job with reason
     */
    public function rejectJob(Request $request, Job $job)
    {
        $request->validate(['reason' => 'required|string|min:10']);

        $job->update([
            'is_approved' => false,
            'is_active' => false
        ]);

        // Notification logic with reason could be added here

        return redirect()->back()->with('success', 'Job has been rejected.');
    }

    /**
     * Manage users
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Apply filters
        if ($request->filled('role') && in_array($request->role, ['admin', 'employer', 'candidate'])) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->with('profile')
            ->latest()
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
        $validated = $request->validate([
            'role' => 'required|in:admin,employer,candidate',
        ]);

        // Prevent self-demotion
        if ($user->id === Auth::id() && $validated['role'] !== 'admin') {
            return redirect()->back()->with('error', 'You cannot demote yourself from admin role.');
        }

        $user->update(['role' => $validated['role']]);

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
        $validated = $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'priority' => 'required|integer|min:0|max:100',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Check if job is already featured
        if (FeaturedJob::where('job_id', $validated['job_id'])->exists()) {
            return redirect()->back()->with('error', 'This job is already featured.');
        }

        FeaturedJob::create($validated);

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
            ->latest()
            ->paginate(15);

        return view('admin.comments.pending', compact('pendingComments'));
    }

    /**
     * System settings page
     */
    public function settings()
    {
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

        $data = match ($reportType) {
            'jobs' => $this->generateJobsReport($period),
            'applications' => $this->generateApplicationsReport($period),
            'users' => $this->generateUsersReport($period),
            default => []
        };

        return view('admin.reports', compact('reportType', 'period', 'data'));
    }

    /**
     * Generate jobs report
     */
    private function generateJobsReport($period)
    {
        $startDate = $this->getStartDateForPeriod($period);

        return [
            'timeSeriesData' => $this->getTimeSeriesData(Job::class, $startDate),
            'categoryData' => Job::where('created_at', '>=', $startDate)
                ->join('job_categories', 'jobs.category_id', '=', 'job_categories.id')
                ->select('job_categories.name', DB::raw('count(*) as count'))
                ->groupBy('job_categories.name')
                ->orderBy('count', 'desc')
                ->pluck('count', 'name')
                ->toArray()
        ];
    }

    /**
     * Generate applications report
     */
    private function generateApplicationsReport($period)
    {
        $startDate = $this->getStartDateForPeriod($period);

        return [
            'timeSeriesData' => $this->getTimeSeriesData(Application::class, $startDate),
            'statusData' => Application::where('created_at', '>=', $startDate)
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->orderBy('count', 'desc')
                ->pluck('count', 'status')
                ->toArray()
        ];
    }

    /**
     * Generate users report
     */
    private function generateUsersReport($period)
    {
        $startDate = $this->getStartDateForPeriod($period);

        return [
            'timeSeriesData' => $this->getTimeSeriesData(User::class, $startDate),
            'roleData' => User::where('created_at', '>=', $startDate)
                ->select('role', DB::raw('count(*) as count'))
                ->groupBy('role')
                ->orderBy('count', 'desc')
                ->pluck('count', 'role')
                ->toArray()
        ];
    }

    /**
     * Get time series data for a model
     */
    private function getTimeSeriesData($modelClass, $startDate)
    {
        return $modelClass::where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();
    }

    /**
     * Get start date based on period
     */
    private function getStartDateForPeriod($period)
    {
        return match ($period) {
            'week' => Carbon::now()->subDays(7),
            'month' => Carbon::now()->subDays(30),
            'quarter' => Carbon::now()->subMonths(3),
            'year' => Carbon::now()->subYear(),
            default => Carbon::now()->subDays(30)
        };
    }
}
