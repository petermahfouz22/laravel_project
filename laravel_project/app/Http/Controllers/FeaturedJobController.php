<?php

namespace App\Http\Controllers;

use App\Models\FeaturedJob;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeaturedJobController extends Controller
{
    /**
     * Display a listing of the featured jobs.
     */
    public function index()
    {
        // Only admin can manage featured jobs
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Only administrators can manage featured jobs.');
        }

        $featuredJobs = FeaturedJob::with('job.company')
            ->orderBy('end_date', 'desc')
            ->paginate(10);

        return view('featured-jobs.index', compact('featuredJobs'));
    }

    /**
     * Show the form for creating a new featured job.
     */
    public function create()
    {
        // Only admin can create featured jobs
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Only administrators can create featured jobs.');
        }

        // Get jobs that are not already featured
        $jobs = Job::whereDoesntHave('featuredJob')
            ->where('is_active', true)
            ->where('is_approved', true)
            ->with('company')
            ->get();

        return view('featured-jobs.create', compact('jobs'));
    }

    /**
     * Store a newly created featured job in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'priority' => 'required|integer|min:1|max:10',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Check if job is already featured
        $existingFeatured = FeaturedJob::where('job_id', $validated['job_id'])->exists();
        if ($existingFeatured) {
            return redirect()->back()->withErrors(['job_id' => 'This job is already featured.']);
        }

        // Create featured job
        FeaturedJob::create($validated);

        return redirect()->route('featured-jobs.index')
            ->with('success', 'Job featured successfully.');
    }

    /**
     * Show the form for editing the specified featured job.
     */
    public function edit(FeaturedJob $featuredJob)
    {
        // Only admin can edit featured jobs
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Only administrators can edit featured jobs.');
        }

        return view('featured-jobs.edit', compact('featuredJob'));
    }

    /**
     * Update the specified featured job in storage.
     */
    public function update(Request $request, FeaturedJob $featuredJob)
    {
        // Validate request
        $validated = $request->validate([
            'priority' => 'required|integer|min:1|max:10',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Update featured job
        $featuredJob->update($validated);

        return redirect()->route('featured-jobs.index')
            ->with('success', 'Featured job updated successfully.');
    }

    /**
     * Remove the specified featured job from storage.
     */
    public function destroy(FeaturedJob $featuredJob)
    {
        // Only admin can delete featured jobs
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Only administrators can remove featured jobs.');
        }

        // Delete featured job
        $featuredJob->delete();

        return redirect()->route('featured-jobs.index')
            ->with('success', 'Job removed from featured listings.');
    }
}