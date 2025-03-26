<?php
namespace App\Http\Controllers\Candidate;
use Illuminate\Support\Facades\Storage;
use App\Models\Resume;
use Illuminate\Http\Request;
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
    
        // Update basic user data
        $user->update([
            'name' => $basicData['name'],
            'email' => $basicData['email'],
        ]);
    
        // Update or create user profile
        $profile = $user->profile ?? $user->profile()->create();
        
        $profileFields = [
            'phone' => $extendedData['phone'] ?? null,
            'location' => $extendedData['location'] ?? null,
            'linkedin_url' => $extendedData['linkedin_url'] ?? null,
            'website' => $extendedData['website'] ?? null,
            'bio' => $extendedData['bio'] ?? null,
        ];
    
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image) {
                Storage::delete($user->profile_image);
            }
        
            // Store new image and update user
            $imagePath = $request->file('profile_image')->store('profile-images', 'public');
            $user->profile_image = $imagePath;
            $user->save();
        }
        // Filter out null values and update profile
        $profile->update(array_filter($profileFields));
    
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
    public function storeResume(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file_path' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5MB
            'is_default' => ['sometimes', 'boolean'],
            'type' => ['nullable', 'in:general,targeted,academic'],
            'tags' => ['nullable', 'array'],
            'visibility' => ['nullable', 'in:private,public']
        ]);
    
        $user = auth()->user();
    
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
    
        return redirect()->route('candidate.profile.resumes')
            ->with('status', 'Resume uploaded successfully!');
    }
    
    public function downloadResume(Resume $resume)
    {
        // Optional: Add authorization check
        if ($resume->candidate_id !== auth()->id()) {
            abort(403);
        }
    
        return Storage::download($resume->file_path, $resume->title . '.pdf');
    }
}