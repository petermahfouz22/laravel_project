<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('is_active', true)
                   ->where('is_approved', true)
                   ->where('application_deadline', '>=', now())
                   ->with('category')
                   ->paginate(10);
        $categories = JobCategory::all();

        return view('candidate.jobs.index', compact('jobs', 'categories'));
    }

    public function show(Job $job)
    {
        // Ensure the job is active, approved, and not expired
        if (!$job->is_active || !$job->is_approved || now()->gt($job->application_deadline)) {
            abort(404, 'This job is no longer available.');
        }

        return view('candidate.jobs.show', compact('job'));
    }

    public function save(Job $job)
{
    /** @var \App\Models\User $user */
    $user = auth()->user();
    $user->savedJobs()->attach($job->id); // Assumes a pivot table
    return redirect()->route('candidate.jobs.show', $job)->with('status', 'Job saved!');
}
public function search(Request $request)
{
    
    $query = Job::where('is_active', true)
               ->where('is_approved', true)
               ->where('application_deadline', '>=', now());
    
    if ($request->has('keyword')) {
        $query->where(function($q) use ($request) {
            $q->where('title', 'like', '%' . $request->keyword . '%')
              ->orWhere('description', 'like', '%' . $request->keyword . '%');
        });
    }
    
    if ($request->has('category_id') && $request->category_id) {
        $query->where('category_id', $request->category_id);
    }
    
    $jobs = $query->with('category')->paginate(10);
    $categories = JobCategory::all();
    
    return view('candidate.jobs.index', compact('jobs', 'categories'));
}
public function savedJobs()
{
    /** @var \App\Models\User $user */
    $user = auth()->user();
    $savedJobs = $user->savedJobs()->with('category')->paginate(10);
    
    return view('candidate.jobs.saved', compact('savedJobs'));
}
}