<?php
namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use App\Models\Job;

class ApplicationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $applications = $user->applications()->with('job')->paginate(10);
        return view('candidate.applications.index', compact('applications'));
    }

    public function create(Job $job)
    {
        return view('candidate.applications.create', compact('job'));
    }

    public function store(StoreApplicationRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $applicationData = $request->validated();

        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $applicationData['resume'] = $resumePath;
        }

        $user->applications()->create($applicationData);

        return redirect()->route('candidate.applications.index')->with('status', 'Application submitted!');
    }
}