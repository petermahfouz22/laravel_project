<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    /**
     * Display a listing of the user's resumes.
     */
    public function index()
    {
        // Only candidates can manage resumes
        if (Auth::user()->role !== 'candidate') {
            return redirect()->route('home')->with('error', 'Only candidates can manage resumes.');
        }

        $resumes = Resume::where('candidate_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('resumes.index', compact('resumes'));
    }

    /**
     * Show the form for creating a new resume.
     */
    public function create()
    {
        // Only candidates can create resumes
        if (Auth::user()->role !== 'candidate') {
            return redirect()->route('home')->with('error', 'Only candidates can create resumes.');
        }

        return view('resumes.create');
    }

    /**
     * Store a newly created resume in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'resume_file' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'is_default' => 'sometimes|boolean',
        ]);

        // Create resume
        $resume = new Resume();
        $resume->candidate_id = Auth::id();
        $resume->title = $validated['title'];
        $resume->file_path = $request->file('resume_file')->store('resumes');
        $resume->is_default = $request->has('is_default');
        $resume->save();

        // If set as default, update other resumes
        if ($resume->is_default) {
            $resume->setAsDefault();
        }

        return redirect()->route('resumes.index')
            ->with('success', 'Resume uploaded successfully.');
    }

    /**
     * Display the specified resume.
     */
    public function show(Resume $resume)
    {
        // Check authorization
        if (Auth::id() !== $resume->candidate_id && Auth::user()->role !== 'admin') {
            return redirect()->route('resumes.index')
                ->with('error', 'You are not authorized to view this resume.');
        }

        // Download file
        return Storage::download($resume->file_path, $resume->title . '.pdf');
    }

    /**
     * Show the form for editing the specified resume.
     */
    public function edit(Resume $resume)
    {
        // Check authorization
        if (Auth::id() !== $resume->candidate_id) {
            return redirect()->route('resumes.index')
                ->with('error', 'You are not authorized to edit this resume.');
        }

        return view('resumes.edit', compact('resume'));
    }

    /**
     * Update the specified resume in storage.
     */
    public function update(Request $request, Resume $resume)
    {
        // Check authorization
        if (Auth::id() !== $resume->candidate_id) {
            return redirect()->route('resumes.index')
                ->with('error', 'You are not authorized to update this resume.');
        }

        // Validate request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'resume_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'is_default' => 'sometimes|boolean',
        ]);

        // Update resume
        $resume->title = $validated['title'];
        
        // Handle file upload if provided
        if ($request->hasFile('resume_file')) {
            // Delete old file
            Storage::delete($resume->file_path);
            
            // Store new file
            $resume->file_path = $request->file('resume_file')->store('resumes');
        }
        
        // Update default status
        if ($request->has('is_default') && $resume->is_default !== true) {
            $resume->is_default = true;
            $resume->setAsDefault();
        }
        
        $resume->save();

        return redirect()->route('resumes.index')
            ->with('success', 'Resume updated successfully.');
    }

    /**
     * Remove the specified resume from storage.
     */
    public function destroy(Resume $resume)
    {
        // Check authorization
        if (Auth::id() !== $resume->candidate_id) {
            return redirect()->route('resumes.index')
                ->with('error', 'You are not authorized to delete this resume.');
        }

        // Delete file
        Storage::delete($resume->file_path);
        
        // Delete resume
        $resume->delete();

        return redirect()->route('resumes.index')
            ->with('success', 'Resume deleted successfully.');
    }
    
    /**
     * Set resume as default.
     */
    public function setDefault(Resume $resume)
    {
        // Check authorization
        if (Auth::id() !== $resume->candidate_id) {
            return redirect()->route('resumes.index')
                ->with('error', 'You are not authorized to modify this resume.');
        }

        // Set as default
        $resume->setAsDefault();

        return redirect()->route('resumes.index')
            ->with('success', 'Default resume updated successfully.');
    }
}