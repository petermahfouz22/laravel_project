<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobCategory;
use App\Models\Technology;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the jobs.
     */
    public function index(Request $request)
    {
        // Retrieve search parameters
        $search = $request->input('search');
        $location = $request->input('location');
        $category = $request->input('category');
        $workType = $request->input('work_type');
        $technology = $request->input('technology');

        // Base query for active and approved jobs
        $query = Job::with(['company', 'category', 'technologies'])
            ->where('is_active', true)
            ->where('is_approved', true)
            ->where('application_deadline', '>=', now());

        // Apply filters
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('company', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($location) {
            $query->where('location', 'like', "%{$location}%");
        }

        if ($category) {
            $query->where('category_id', $category);
        }

        if ($workType) {
            $query->where('work_type', $workType);
        }

        if ($technology) {
            $query->whereHas('technologies', function ($q) use ($technology) {
                $q->where('technology_id', $technology);
            });
        }

        // Order by creation date, most recent first
        $jobs = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get all categories and technologies for filters
        $categories = JobCategory::all();
        $technologies = Technology::all();

        return view('jobs.index', compact('jobs', 'categories', 'technologies', 'search', 'location', 'category', 'workType', 'technology'));
    }

    /**
     * Show the form for creating a new job.
     * Employer only access.
     */
    public function create()
    {
        // Verify employer access
        if (!auth()->user()->isEmployer()) {
            return redirect()->route('dashboard')
                ->with('error', 'You must be an employer to post jobs.');
        }

        // Check if employer has a company
        if (!auth()->user()->company) {
            return redirect()->route('companies.create')
                ->with('info', 'You need to create a company profile before posting jobs.');
        }

        $categories = JobCategory::all();
        $technologies = Technology::all();

        return view('jobs.create', compact('categories', 'technologies'));
    }

    /**
     * Store a newly created job in storage.
     * Employer only access.
     */
    public function store(Request $request)
    {
        // Verify employer access
        if (!auth()->user()->isEmployer()) {
            return redirect()->route('dashboard')
                ->with('error', 'You must be an employer to post jobs.');
        }

        // Check if employer has a company
        if (!auth()->user()->company) {
            return redirect()->route('companies.create')
                ->with('info', 'You need to create a company profile before posting jobs.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:job_categories,id',
            'description' => 'required|string',
            'responsibilities' => 'required|string',
            'requirements' => 'required|string',
            'benefits' => 'nullable|string',
            'location' => 'required|string|max:255',
            'work_type' => 'required|in:remote,onsite,hybrid',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'application_deadline' => 'required|date|after:today',
            'technologies' => 'nullable|array',
            'technologies.*' => 'exists:technologies,id',
        ]);

        // Create slug from title
        $slug = Str::slug($validated['title']);
        $baseSlug = $slug;
        $counter = 1;

        // Ensure slug is unique
        while (Job::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        // Create the job
        $job = new Job();
        $job->employer_id = auth()->id();
        $job->company_id = auth()->user()->company->id;
        $job->category_id = $validated['category_id'];
        $job->title = $validated['title'];
        $job->slug = $slug;
        $job->description = $validated['description'];
        $job->responsibilities = $validated['responsibilities'];
        $job->requirements = $validated['requirements'];
        $job->benefits = $validated['benefits'];
        $job->location = $validated['location'];
        $job->work_type = $validated['work_type'];
        $job->salary_min = $validated['salary_min'];
        $job->salary_max = $validated['salary_max'];
        $job->application_deadline = $validated['application_deadline'];
        $job->is_active = true;
        $job->is_approved = false; // New jobs require admin approval
        $job->save();

        // Attach technologies
        if (isset($validated['technologies'])) {
            $job->technologies()->attach($validated['technologies']);
        }

        return redirect()->route('jobs.show', $job->slug)
            ->with('success', 'Job listing created successfully. It will be visible after admin approval.');
    }

    /**
     * Display the specified job.
     */
    public function show(string $slug)
    {
        $job = Job::where('slug', $slug)
            ->with(['company', 'category', 'technologies', 'employer'])
            ->firstOrFail();

        // Check if job is inactive or unapproved - only employer and admin can see
        if (
            (!$job->is_active || !$job->is_approved) &&
            (!auth()->check() ||
                (auth()->id() !== $job->employer_id && !auth()->user()->isAdmin()))
        ) {

            return redirect()->route('jobs.index')
                ->with('error', 'This job listing is not available.');
        }

        // Increment view count
        if (!session()->has("job_viewed_{$job->id}")) {
            $job->increment('views_count');
            session(["job_viewed_{$job->id}" => true]);
        }

        // Check if user has already applied
        $hasApplied = false;
        if (auth()->check() && auth()->user()->isCandidate()) {
            $hasApplied = Application::where('job_id', $job->id)
                ->where('candidate_id', auth()->id())
                ->exists();
        }

        // Get similar jobs
        $similarJobs = Job::where('category_id', $job->category_id)
            ->where('id', '!=', $job->id)
            ->where('is_active', true)
            ->where('is_approved', true)
            ->where('application_deadline', '>=', now())
            ->limit(3)
            ->get();

        return view('jobs.show', compact('job', 'hasApplied', 'similarJobs'));
    }

    /**
     * Show the form for editing the specified job.
     * Only job employer or admin can edit.
     */
    public function edit(string $id)
    {
        $job = Job::findOrFail($id);

        // Verify access (job employer or admin)
        if (auth()->id() !== $job->employer_id && !auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You don\'t have permission to edit this job.');
        }

        $categories = JobCategory::all();
        $technologies = Technology::all();

        return view('jobs.edit', compact('job', 'categories', 'technologies'));
    }

    /**
     * Update the specified job in storage.
     * Only job employer or admin can update.
     */
    public function update(Request $request, string $id)
    {
        $job = Job::findOrFail($id);

        // Verify access (job employer or admin)
        if (auth()->id() !== $job->employer_id && !auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You don\'t have permission to update this job.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:job_categories,id',
            'description' => 'required|string',
            'responsibilities' => 'required|string',
            'requirements' => 'required|string',
            'benefits' => 'nullable|string',
            'location' => 'required|string|max:255',
            'work_type' => 'required|in:remote,onsite,hybrid',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'application_deadline' => 'required|date',
            'is_active' => 'boolean',
            'technologies' => 'nullable|array',
            'technologies.*' => 'exists:technologies,id',
        ]);

        // Update job details
        $job->title = $validated['title'];

        // Only update slug if title has changed
        if ($job->title !== $validated['title']) {
            $slug = Str::slug($validated['title']);
            $baseSlug = $slug;
            $counter = 1;

            // Ensure slug is unique
            while (Job::where('slug', $slug)->where('id', '!=', $job->id)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            $job->slug = $slug;
        }

        $job->category_id = $validated['category_id'];
        $job->description = $validated['description'];
        $job->responsibilities = $validated['responsibilities'];
        $job->requirements = $validated['requirements'];
        $job->benefits = $validated['benefits'];
        $job->location = $validated['location'];
        $job->work_type = $validated['work_type'];
        $job->salary_min = $validated['salary_min'];
        $job->salary_max = $validated['salary_max'];
        $job->application_deadline = $validated['application_deadline'];

        // Only employer can toggle active status
        if (isset($validated['is_active'])) {
            $job->is_active = $validated['is_active'];
        }

        // Only admin can approve jobs
        if (auth()->user()->isAdmin() && $request->has('is_approved')) {
            $job->is_approved = $request->boolean('is_approved');
        }

        $job->save();

        // Sync technologies
        if (isset($validated['technologies'])) {
            $job->technologies()->sync($validated['technologies']);
        } else {
            $job->technologies()->detach();
        }

        return redirect()->route('jobs.show', $job->slug)
            ->with('success', 'Job listing updated successfully.');
    }

    /**
     * Remove the specified job from storage.
     * Only job employer or admin can delete.
     */
    public function destroy(string $id)
    {
        $job = Job::findOrFail($id);

        // Verify access (job employer or admin)
        if (auth()->id() !== $job->employer_id && !auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You don\'t have permission to delete this job.');
        }

        $job->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Job listing deleted successfully.');
    }

    /**
     * Display jobs dashboard for employers.
     * Employer only access.
     */
    public function employerJobs()
    {
        // Verify employer access
        if (!auth()->user()->isEmployer()) {
            return redirect()->route('dashboard')
                ->with('error', 'You must be an employer to access this page.');
        }

        $activeJobs = Job::where('employer_id', auth()->id())
            ->where('is_active', true)
            ->latest()
            ->get();

        $inactiveJobs = Job::where('employer_id', auth()->id())
            ->where('is_active', false)
            ->latest()
            ->get();

        $pendingJobs = Job::where('employer_id', auth()->id())
            ->where('is_approved', false)
            ->latest()
            ->get();

        return view('employer.jobs', compact('activeJobs', 'inactiveJobs', 'pendingJobs'));
    }

    /**
     * Admin job approval dashboard.
     * Admin only access.
     */
    public function adminJobs()
    {
        // Verify admin access
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this page.');
        }

        $pendingJobs = Job::where('is_approved', false)
            ->with(['company', 'employer'])
            ->latest()
            ->paginate(10);

        return view('admin.jobs.pending', compact('pendingJobs'));
    }

    /**
     * Approve a job listing.
     * Admin only access.
     */
    public function approve(string $id)
    {
        // Verify admin access
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to approve job listings.');
        }

        $job = Job::findOrFail($id);
        $job->is_approved = true;
        $job->save();

        return redirect()->back()
            ->with('success', 'Job listing approved successfully.');
    }

    /**
     * Save a job to user's favorites.
     * Candidate only access.
     */
    public function saveJob(string $id)
    {
        $job = Job::findOrFail($id);

        // Verify candidate access
        if (!auth()->user()->isCandidate()) {
            return redirect()->back()
                ->with('error', 'Only job seekers can save jobs.');
        }

        auth()->user()->savedJobs()->syncWithoutDetaching([$id]);

        return redirect()->back()
            ->with('success', 'Job saved to your favorites.');
    }

    /**
     * Remove a job from user's favorites.
     * Candidate only access.
     */
    public function unsaveJob(string $id)
    {
        // Verify candidate access
        if (!auth()->user()->isCandidate()) {
            return redirect()->back()
                ->with('error', 'Only job seekers can manage saved jobs.');
        }

        auth()->user()->savedJobs()->detach($id);

        return redirect()->back()
            ->with('success', 'Job removed from your favorites.');
    }
}