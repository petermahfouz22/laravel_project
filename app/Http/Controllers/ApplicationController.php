<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the applications for the current user.
     */
    public function index()
    {
        $user = Auth::user();
        $applications = [];

        if ($user->role === 'candidate') {
            // For candidates, show their applications
            $applications = Application::where('candidate_id', $user->id)
                ->with(['job.company'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
                
            return view('applications.candidate.index', compact('applications'));
        } elseif ($user->role === 'employer') {
            // For employers, show applications to their jobs
            $applications = Application::whereHas('job', function($query) use ($user) {
                $query->where('employer_id', $user->id);
            })
            ->with(['job', 'candidate'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
            return view('applications.employer.index', compact('applications'));
        } else {
            // For admins, show all applications
            $applications = Application::with(['job.company', 'candidate'])
                ->orderBy('created_at', 'desc')
                ->paginate(20);
                
            return view('applications.admin.index', compact('applications'));
        }
    }

    /**
     * Show the form for creating a new application.
     */
    public function create(Job $job)
    {
        // Check if job is active and approved
        if (!$job->is_active || !$job->is_approved) {
            return redirect()->route('jobs.index')
                ->with('error', 'This job is no longer accepting applications.');
        }

        // Check if user is a candidate
        if (Auth::user()->role !== 'candidate') {
            return redirect()->route('jobs.show', $job->slug)
                ->with('error', 'Only candidates can apply for jobs.');
        }

        // Check if user already applied
        $existingApplication = Application::where('job_id', $job->id)
            ->where('candidate_id', Auth::id())
            ->exists();

        if ($existingApplication) {
            return redirect()->route('jobs.show', $job->slug)
                ->with('info', 'You have already applied for this job.');
        }

        // Get user's resumes
        $resumes = Resume::where('candidate_id', Auth::id())->get();
        
        return view('applications.create', compact('job', 'resumes'));
    }

    /**
     * Store a newly created application in storage.
     */
    public function store(Request $request, Job $job)
    {
        // Validate request
        $validated = $request->validate([
            'cover_letter' => 'required|string|min:100',
            'resume_id' => 'nullable|exists:resumes,id',
            'resume_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Check if either existing resume or new upload is provided
        if (!$request->has('resume_id') && !$request->hasFile('resume_file')) {
            return redirect()->back()->withErrors(['resume' => 'Please select an existing resume or upload a new one.']);
        }

        // Create application
        $application = new Application();
        $application->job_id = $job->id;
        $application->candidate_id = Auth::id();
        $application->cover_letter = $validated['cover_letter'];
        $application->status = 'pending';

        // Handle resume selection/upload
        if ($request->hasFile('resume_file')) {
            $path = $request->file('resume_file')->store('resumes');
            $application->resume = $path;
        } elseif ($request->has('resume_id')) {
            $resume = Resume::findOrFail($validated['resume_id']);
            $application->resume = $resume->file_path;
        }

        $application->save();

        // Increment application count
        $job->increment('applications_count');

        return redirect()->route('applications.index')
            ->with('success', 'Your application has been submitted successfully.');
    }

    /**
     * Display the specified application.
     */
    public function show(Application $application)
    {
        // Check if user can view this application
        $user = Auth::user();
        
        if ($user->role === 'candidate' && $application->candidate_id !== $user->id) {
            return redirect()->route('applications.index')
                ->with('error', 'You are not authorized to view this application.');
        }

        if ($user->role === 'employer' && $application->job->employer_id !== $user->id) {
            return redirect()->route('applications.index')
                ->with('error', 'You are not authorized to view this application.');
        }

        // Load related models
        $application->load(['job.company', 'candidate']);
        
        return view('applications.show', compact('application'));
    }

    /**
     * Update the application status (employer only).
     */
    public function updateStatus(Request $request, Application $application)
    {
        // Check if user is employer of this job
        if (Auth::id() !== $application->job->employer_id && Auth::user()->role !== 'admin') {
            return redirect()->route('applications.index')
                ->with('error', 'You are not authorized to update this application.');
        }

        // Validate request
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
            'notes' => 'nullable|string',
        ]);

        // Update application
        $application->status = $validated['status'];
        
        if (isset($validated['notes'])) {
            $application->notes = $validated['notes'];
        }
        
        $application->save();

        return redirect()->route('applications.show', $application)
            ->with('success', 'Application status updated successfully.');
    }

    /**
     * Download application resume.
     */
    public function downloadResume(Application $application)
    {
        // Check if user can download this resume
        $user = Auth::user();
        
        if ($user->role === 'candidate' && $application->candidate_id !== $user->id) {
            return redirect()->route('applications.index')
                ->with('error', 'You are not authorized to download this resume.');
        }

        if ($user->role === 'employer' && $application->job->employer_id !== $user->id) {
            return redirect()->route('applications.index')
                ->with('error', 'You are not authorized to download this resume.');
        }

        // Download file
        return Storage::download($application->resume);
    }
}