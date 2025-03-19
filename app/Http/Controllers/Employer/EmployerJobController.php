<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\Technology;
use Illuminate\Support\Str;

class EmployerJobController extends Controller
{
    /**
     * Display a listing of the jobs for this employer.
     */
    public function index()
    {
        $jobs = Job::where('employer_id', auth()->id())
            ->with(['company', 'category'])
            ->latest()
            ->paginate(10);
            
        return view('employer.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new job.
     */
    public function create()
    {
        $companies = Company::where('user_id', auth()->id())->get();
        $categories = JobCategory::all();
        $technologies = Technology::all();
        
        return view('employer.jobs.create', compact(
            'companies',
            'categories',
            'technologies'
        ));
    }

    /**
     * Store a newly created job in storage.
     */
    public function store(Request $request)
    {
        // Generate a unique slug from the title
        $slug = Str::slug($request->title);
        
        // Check if slug exists and make it unique if needed
        $existingSlugCount = Job::where('slug', 'LIKE', $slug . '%')->count();
        if ($existingSlugCount > 0) {
            $slug = $slug . '-' . ($existingSlugCount + 1);
        }
        
        // Create the job
        $job = Job::create([
            'employer_id' => auth()->id(),
            'company_id' => $request->company_id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'responsibilities' => $request->responsibilities,
            'requirements' => $request->requirements,
            'benefits' => $request->benefits,
            'location' => $request->location,
            'work_type' => $request->work_type,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'application_deadline' => $request->application_deadline,
            'is_active' => $request->has('is_active'),
            'is_approved' => false, // Requires admin approval
        ]);
        
        // Attach technologies
        if ($request->has('technologies')) {
            $job->technologies()->attach($request->technologies);
        }
        
        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job created successfully and pending approval.');
    }

    /**
     * Display the specified job.
     */
    public function show($id)
    {
        $job = Job::where('employer_id', auth()->id())
            ->with(['company', 'category', 'technologies', 'applications.candidate'])
            ->findOrFail($id);
            
        return view('employer.jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit($id)
    {
        $job = Job::where('employer_id', auth()->id())->findOrFail($id);
        $companies = Company::where('user_id', auth()->id())->get();
        $categories = JobCategory::all();
        $technologies = Technology::all();
        
        return view('employer.jobs.edit', compact(
            'job',
            'companies',
            'categories',
            'technologies'
        ));
    }

    /**
     * Update the specified job in storage.
     */
    public function update(Request $request, $id)
    {
        $job = Job::where('employer_id', auth()->id())->findOrFail($id);
        
        // Update job details
        $job->update([
            'company_id' => $request->company_id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'responsibilities' => $request->responsibilities,
            'requirements' => $request->requirements,
            'benefits' => $request->benefits,
            'location' => $request->location,
            'work_type' => $request->work_type,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'application_deadline' => $request->application_deadline,
            'is_active' => $request->has('is_active'),
            // Don't change approval status on update
        ]);
        
        // Sync technologies
        if ($request->has('technologies')) {
            $job->technologies()->sync($request->technologies);
        } else {
            $job->technologies()->detach();
        }
        
        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified job from storage.
     */
    public function destroy($id)
    {
        $job = Job::where('employer_id', auth()->id())->findOrFail($id);
        $job->delete();
        
        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job deleted successfully.');
    }
    
    /**
     * Toggle the active status of a job
     */
    public function toggleActive($id)
    {
        $job = Job::where('employer_id', auth()->id())->findOrFail($id);
        $job->is_active = !$job->is_active;
        $job->save();
        
        return redirect()->back()
            ->with('success', 'Job status updated successfully.');
    }
}