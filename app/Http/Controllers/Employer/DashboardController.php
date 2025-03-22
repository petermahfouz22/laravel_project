<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;

class DashboardController extends Controller
{
    /**
     * Display the employer dashboard with summary metrics
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get count of jobs posted by this employer
        $jobsCount = Job::where('employer_id', $user->id)->count();
        
        // Get count of job applications received
        $applicationsCount = Application::whereHas('job', function($query) use ($user) {
            $query->where('employer_id', $user->id);
        })->count();
        
        // Get count of active jobs
        $activeJobsCount = Job::where('employer_id', $user->id)
            ->where('is_active', true)
            ->where('application_deadline', '>=', now())
            ->count();
        
        // Get recent applications with pagination
        $recentApplications = Application::whereHas('job', function($query) use ($user) {
            $query->where('employer_id', $user->id);
        })
        ->with(['job', 'candidate'])
        ->latest()
        ->paginate(5); // Using paginate instead of take
        
        return view('employer.dashboard', compact(
            'jobsCount', 
            'applicationsCount', 
            'activeJobsCount', 
            'recentApplications'
        ));
    }
}