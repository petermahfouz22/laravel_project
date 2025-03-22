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
        return view('candidate.profile');
    }

    public function update(ProfileUpdateRequest $request, UpdateProfileRequest $extendedRequest): RedirectResponse
    {
        /** @var User $user */
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

    public function storeResume(StoreResumeRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $resumeData = $request->validated();
        // Assuming a Resume model exists
        $user->resumes()->create($resumeData);

        return redirect()->route('candidate.profile.index')->with('status', 'Resume uploaded!');
    }
}