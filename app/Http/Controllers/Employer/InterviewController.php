<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Interview;
use App\Models\Job;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    /**
     * Display a listing of interviews for an employer
     */
    public function index()
    {
        $interviews = Interview::whereHas('application.job', function($query) {
            $query->where('employer_id', auth()->id());
        })
        ->with(['application.job', 'application.candidate'])
        ->latest()
        ->paginate(10);
        
        return view('employer.interviews.index', compact('interviews'));
    }
    
    /**
     * Show the form for creating a new interview
     */
    public function create($jobId, $applicationId)
    {
        $job = Job::where('employer_id', auth()->id())
            ->findOrFail($jobId);
            
        $application = Application::where('job_id', $job->id)
            ->with('candidate')
            ->findOrFail($applicationId);
            
        return view('employer.interviews.create', compact('job', 'application'));
    }
    
    /**
     * Store a newly created interview in storage
     */
    public function store(Request $request, $jobId, $applicationId)
    {
        $job = Job::where('employer_id', auth()->id())
            ->findOrFail($jobId);
            
        $application = Application::where('job_id', $job->id)
            ->findOrFail($applicationId);
            
        Interview::create([
            'application_id' => $application->id,
            'scheduled_at' => $request->scheduled_at,
            'duration' => $request->duration,
            'location' => $request->location,
            'is_online' => $request->has('is_online'),
            'meeting_link' => $request->meeting_link,
            'notes' => $request->notes,
        ]);
        
        // Update application status to reflect interview scheduled
        $application->status = 'pending';
        $application->save();
        
        return redirect()->route('employer.interviews.index')
            ->with('success', 'Interview scheduled successfully.');
    }
    
    /**
     * Display the specified interview
     */
    public function show($id)
    {
        $interview = Interview::whereHas('application.job', function($query) {
            $query->where('employer_id', auth()->id());
        })
        ->with(['application.job', 'application.candidate'])
        ->findOrFail($id);
        
        return view('employer.interviews.show', compact('interview'));
    }
    
    /**
     * Show the form for editing the specified interview
     */
    public function edit($id)
    {
        $interview = Interview::whereHas('application.job', function($query) {
            $query->where('employer_id', auth()->id());
        })
        ->with(['application.job', 'application.candidate'])
        ->findOrFail($id);
        
        return view('employer.interviews.edit', compact('interview'));
    }
    
    /**
     * Update the specified interview in storage
     */
    public function update(Request $request, $id)
    {
        $interview = Interview::whereHas('application.job', function($query) {
            $query->where('employer_id', auth()->id());
        })->findOrFail($id);
        
        $interview->update([
            'scheduled_at' => $request->scheduled_at,
            'duration' => $request->duration,
            'location' => $request->location,
            'is_online' => $request->has('is_online'),
            'meeting_link' => $request->meeting_link,
            'notes' => $request->notes,
        ]);
        
        return redirect()->route('employer.interviews.index')
            ->with('success', 'Interview updated successfully.');
    }
    
    /**
     * Remove the specified interview from storage
     */
    public function destroy($id)
    {
        $interview = Interview::whereHas('application.job', function($query) {
            $query->where('employer_id', auth()->id());
        })->findOrFail($id);
        
        $interview->delete();
        
        return redirect()->route('employer.interviews.index')
            ->with('success', 'Interview cancelled successfully.');
    }
    
    /**
     * Mark an interview as completed
     */
    public function markCompleted(Request $request, $id)
    {
        $interview = Interview::whereHas('application.job', function($query) {
            $query->where('employer_id', auth()->id());
        })->findOrFail($id);
        
        $interview->update([
            'completed' => true,
            'outcome_notes' => $request->outcome_notes,
        ]);
        
        return redirect()->route('employer.interviews.index')
            ->with('success', 'Interview marked as completed.');
    }
}