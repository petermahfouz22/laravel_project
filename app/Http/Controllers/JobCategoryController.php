<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of all job categories.
     */

     
    public function adminJobsIndex(Request $request)
    {
        // Verify admin access
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this page.');
        }
        
        // Base query for jobs
        $query = Job::with(['company', 'employer', 'category']);
        
        // Apply filters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('company', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }
        
        if ($request->filled('status')) {
            switch ($request->input('status')) {
                case 'approved':
                    $query->where('is_approved', true);
                    break;
                case 'pending':
                    $query->where('is_approved', false);
                    break;
                case 'active':
                    $query->where('is_active', true);
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
            }
        }
        
        // Order by creation date, most recent first
        $jobs = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get all categories for filters
        $categories = JobCategory::all();
        
        return view('admin.jobs.index', compact('jobs', 'categories'));
    }
    /**
     * Show the form for creating a new category (admin only).
     */
    public function create()
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('categories.index')
                ->with('error', 'Only administrators can create categories.');
        }
        
        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('categories.index')
                ->with('error', 'Only administrators can create categories.');
        }
        
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:job_categories',
            'description' => 'nullable|string'
        ]);
        
        // Create category
        $category = new JobCategory();
        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);
        $category->description = $validated['description'] ?? null;
        $category->save();
        
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified category along with its jobs.
     */
    public function show($slug)
    {
        // Find category by slug
        $category = JobCategory::where('slug', $slug)->firstOrFail();
        
        // Get active and approved jobs in this category
        $jobs = Job::where('category_id', $category->id)
            ->where('is_active', true)
            ->where('is_approved', true)
            ->where('application_deadline', '>=', now())
            ->with(['company', 'technologies'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('categories.show', compact('category', 'jobs'));
    }

    /**
     * Show the form for editing the category (admin only).
     */
    public function edit(JobCategory $category)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('categories.index')
                ->with('error', 'Only administrators can edit categories.');
        }
        
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, JobCategory $category)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('categories.index')
                ->with('error', 'Only administrators can update categories.');
        }
        
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:job_categories,name,' . $category->id,
            'description' => 'nullable|string'
        ]);
        
        // Update category
        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);
        $category->description = $validated['description'] ?? null;
        $category->save();
        
        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(JobCategory $category)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('categories.index')
                ->with('error', 'Only administrators can delete categories.');
        }
        
        // Check if category has jobs
        $jobCount = Job::where('category_id', $category->id)->count();
        
        if ($jobCount > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete category with associated jobs. Please reassign jobs first.');
        }
        
        // Delete category
        $category->delete();
        
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
    
    /**
     * Get a list of all categories for API.
     */
    public function apiList()
    {
        $categories = JobCategory::select('id', 'name')
            ->orderBy('name')
            ->get();
            
        return response()->json($categories);
    }
}