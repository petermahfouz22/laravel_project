<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicantController extends Controller
{
    /**
     * Display all applications for a specific job
     */
    public function index($jobId)
    {
        $job = Job::where('employer_id', auth()->id())
            ->findOrFail($jobId);
            
        $applications = Application::where('job_id', $job->id)
            ->with(['candidate', 'candidate.profile'])
            ->latest()
            ->paginate(15);
            
        return view('employer.applications.index', compact('job', 'applications'));
    }
    
    /**
     * Display details of a specific application
     */
    public function show($jobId, $applicationId)
    {
        $job = Job::where('employer_id', auth()->id())
            ->findOrFail($jobId);
            
        $application = Application::where('job_id', $job->id)
            ->with(['candidate', 'candidate.profile'])
            ->findOrFail($applicationId);
            
        return view('employer.applications.show', compact('job', 'application'));
    }
    
    /**
     * Update the status of an application
     */
    public function updateStatus(Request $request, $jobId, $applicationId)
    {
        $job = Job::where('employer_id', auth()->id())
            ->findOrFail($jobId);
            
        $application = Application::where('job_id', $job->id)
            ->findOrFail($applicationId);
            
        $application->status = $request->status;
        $application->notes = $request->notes;
        $application->save();
        
        return redirect()->route('employer.applications.show', [$jobId, $applicationId])
            ->with('success', 'Application status updated successfully.');
    }
    
    /**
     * Download the resume for an application
     */
    public function downloadResume($jobId, $applicationId)
    {
        $job = Job::where('employer_id', auth()->id())
            ->findOrFail($jobId);
            
        $application = Application::where('job_id', $job->id)
            ->findOrFail($applicationId);
            
        if (!$application->resume) {
            return redirect()->back()->with('error', 'No resume found for this application.');
        }
        
        return Storage::download($application->resume);
    }
}