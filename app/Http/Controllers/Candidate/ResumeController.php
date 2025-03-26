<?php
namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    /**
     * Display a listing of the user's resumes.
     */
    public function index()
    {
        $user = Auth::user()->load('resumes');
        return view('candidate.profile.resumes', compact('user'));
    }

    /**
     * Show the form for creating a new resume.
     */
    public function create()
    {
        return view('candidate.profile.resume-upload');
    }

    /**
     * Store a newly created resume in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file_path' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5MB
            'is_default' => ['sometimes', 'boolean'],
            'type' => ['nullable', 'in:general,targeted,academic'],
            'tags' => ['nullable', 'array'],
            'visibility' => ['nullable', 'in:private,public']
        ]);

        $user = Auth::user();

        // Store the file
        $filePath = $request->file('file_path')->store('resumes', 'public');

        // Create the resume
        $resume = $user->resumes()->create([
            'title' => $request->input('title'),
            'file_path' => $filePath,
            'type' => $request->input('type', 'general'),
            'tags' => $request->input('tags', []),
            'visibility' => $request->input('visibility', 'private'),
            'is_default' => $request->boolean('is_default')
        ]);

        // If set as default, update other resumes
        if ($resume->is_default) {
            $resume->setAsDefault();
        }

        \Log::info('Uploaded Resume Path', [
          'original_name' => $request->file('file_path')->getClientOriginalName(),
          'stored_path' => $filePath
      ]);

        return redirect()->route('candidate.profile.resumes')
            ->with('status', 'Resume uploaded successfully!');
    }

    /**
     * Download a specific resume.
     */
    public function download(Resume $resume)
{
    // Ensure the user can only download their own resumes
    if ($resume->candidate_id !== Auth::id()) {
        abort(403, 'Unauthorized access');
    }

    // Use public disk and full path
    $fullPath = storage_path('app/public/' . $resume->file_path);

    // Check if file exists
    if (!file_exists($fullPath)) {
        abort(404, 'File not found');
    }

    // Get original filename
    $filename = basename($resume->file_path);

    return response()->download($fullPath, $filename);
}

    /**
     * Set a resume as default.
     */
    public function setDefault(Resume $resume)
    {
        // Ensure the user can only set their own resumes as default
        if ($resume->candidate_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $resume->setAsDefault();

        return redirect()->route('candidate.profile.resumes')
            ->with('status', 'Default resume updated successfully!');
    }

    /**
     * Delete a resume.
     */
    public function destroy(Resume $resume)
    {
        // Ensure the user can only delete their own resumes
        if ($resume->candidate_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Delete the file from storage
        if (Storage::exists($resume->file_path)) {
            Storage::delete($resume->file_path);
        }

        // Delete the resume record
        $resume->delete();

        return redirect()->route('candidate.profile.resumes')
            ->with('status', 'Resume deleted successfully!');
    }
}