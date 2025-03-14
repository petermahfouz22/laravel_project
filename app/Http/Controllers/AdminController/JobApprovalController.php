<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobCategory;
use App\Models\FeaturedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JobApprovalController extends Controller
{
    /**
     * Constructor - Apply admin middleware
     */
    public function __construct()
    {
        $this->middleware('admin');
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
     * Generate jobs report
     */
    public function jobsReport($period = 'month')
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