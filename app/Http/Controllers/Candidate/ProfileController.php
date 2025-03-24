<?php
namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\StoreResumeRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('candidate.profile.index', compact('user'));
    }

    public function update(ProfileUpdateRequest $request, UpdateProfileRequest $extendedRequest): RedirectResponse
    {
        $user = auth()->user();
        $basicData = $request->validated();
        $extendedData = $extendedRequest->validated();

        $user->update(array_merge(
            [
                'name' => $basicData['name'],
                'email' => $basicData['email'],
            ],
            array_filter($extendedData)
        ));

        return redirect()->route('candidate.profile.index')->with('status', 'Profile updated!');
    }
    public function edit()
    {
        $user = auth()->user();
        return view('candidate.profile.edit', compact('user'));
    }
    public function resumes()
    {
        $user = auth()->user()->load('resumes');
        return view('candidate.profile.resumes', compact('user'));
    }
    public function storeResume(StoreResumeRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $resumeData = $request->validated();
    
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $resumeData = ['path' => $resumePath];
        }
    
        $user->resumes()->create($resumeData);
    
        return redirect()->route('candidate.profile.index')->with('status', 'Resume uploaded!');
    }
}