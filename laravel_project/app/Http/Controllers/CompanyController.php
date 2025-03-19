<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the companies.
     * Admin only access.
     */
    public function index()
    {
        // Verify admin access
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'no permission');
        }

        $companies = Company::with('user')->latest()->paginate(10);
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new company.
     * Employer only access.
     */
    public function create()
    {
        // Verify employer access
        if (!auth()->user()->isEmployer()) {
            return redirect()->route('dashboard')->with('error', 'You must be a business owner to create a company.');
        }

        // Check if employer already has a company
        if (auth()->user()->company) {
            return redirect()->route('companies.edit', auth()->user()->company)
                ->with('info', '');
        }

        return view('companies.create');
    }

    /**
     * Store a newly created company in storage.
     * Employer only access.
     */
    public function store(Request $request)
    {
        // Verify employer access
        if (!auth()->user()->isEmployer()) {
            return redirect()->route('dashboard')->with('error', 'يجب أن تكون صاحب عمل لإنشاء شركة.');
        }

        // Check if employer already has a company
        if (auth()->user()->company) {
            return redirect()->route('companies.edit', auth()->user()->company)
                ->with('info', 'لديك شركة بالفعل. يمكنك تعديل بياناتها هنا.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'nullable|image|max:2048', // max 2MB
            'website' => 'nullable|url|max:255',
            'location' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'size' => 'nullable|string|max:50',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('company_logos', 'public');
            $validated['logo'] = $path;
        }

        // Add user_id to the validated data
        $validated['user_id'] = auth()->id();

        $company = Company::create($validated);

        return redirect()->route('companies.show', $company)
            ->with('success', 'تم إنشاء الشركة بنجاح.');
    }

    /**
     * Display the specified company.
     */
    public function show(Company $company)
    {
        // Get company's active jobs
        $jobs = $company->jobs()
            ->where('is_active', true)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('companies.show', compact('company', 'jobs'));
    }

    /**
     * Show the form for editing the specified company.
     * Only company owner or admin can edit.
     */
    public function edit(Company $company)
    {
        // Verify access (company owner or admin)
        if (auth()->id() !== $company->user_id && !auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'غير مصرح بالوصول.');
        }

        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified company in storage.
     * Only company owner or admin can update.
     */
    public function update(Request $request, Company $company)
    {
        // Verify access (company owner or admin)
        if (auth()->id() !== $company->user_id && !auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'غير مصرح بالوصول.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'nullable|image|max:2048', // max 2MB
            'website' => 'nullable|url|max:255',
            'location' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'size' => 'nullable|string|max:50',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($company->logo) {
                Storage::delete('public/' . $company->logo);
            }
            
            $path = $request->file('logo')->store('company_logos', 'public');
            $validated['logo'] = $path;
        }

        $company->update($validated);

        return redirect()->route('companies.show', $company)
            ->with('success', 'تم تحديث بيانات الشركة بنجاح.');
    }

    /**
     * Remove the specified company from storage.
     * Only company owner or admin can delete.
     */
    public function destroy(Company $company)
    {
        // Verify access (company owner or admin)
        if (auth()->id() !== $company->user_id && !auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'غير مصرح بالوصول.');
        }

        // Delete company logo if exists
        if ($company->logo) {
            Storage::delete('public/' . $company->logo);
        }

        $company->delete();

        return redirect()->route('dashboard')
            ->with('success', 'تم حذف الشركة بنجاح.');
    }
    
    /**
     * Remove the company logo.
     * Only company owner or admin can remove logo.
     */
    public function removeLogo(Company $company)
    {
        // Verify access (company owner or admin)
        if (auth()->id() !== $company->user_id && !auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'غير مصرح بالوصول.');
        }

        // Delete logo if exists
        if ($company->logo) {
            Storage::delete('public/' . $company->logo);
            $company->update(['logo' => null]);
        }

        return redirect()->route('companies.edit', $company)
            ->with('success', 'تم حذف شعار الشركة بنجاح.');
    }
}