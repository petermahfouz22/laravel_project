<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyProfileController extends Controller
{
    /**
     * Display a listing of the employer's companies
     */
    public function index()
    {
        $companies = Company::where('user_id', auth()->id())
            ->latest()
            ->get();
            
        return view('employer.companies.index', compact('companies'));
    }
    
    /**
     * Show the form for creating a new company
     */
    public function create()
    {
        return view('employer.companies.create');
    }
    
    /**
     * Store a newly created company in storage
     */
    public function store(Request $request)
    {
        // Handle logo upload
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company-logos', 'public');
        }
        $slug = Str::slug($request->name);
        // Create company
        Company::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $slug, 
            'logo' => $logoPath,
            'website' => $request->website,
            'location' => $request->location,
            'industry' => $request->industry,
            'size' => $request->size,
            'founded_year' => $request->founded_year,
        ]);
        
        return redirect()->route('employer.companies.index')
            ->with('success', 'Company profile created successfully.');
    }
    
    /**
     * Display the specified company
     */
    public function show($id)
    {
        $company = Company::where('user_id', auth()->id())
            ->findOrFail($id);
            
        return view('employer.companies.show', compact('company'));
    }
    
    /**
     * Show the form for editing the specified company
     */
    public function edit($id)
    {
        $company = Company::where('user_id', auth()->id())
            ->findOrFail($id);
            
        return view('employer.companies.edit', compact('company'));
    }
    
    /**
     * Update the specified company in storage
     */
    public function update(Request $request, $id)
    {
        $company = Company::where('user_id', auth()->id())
            ->findOrFail($id);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            
            $logoPath = $request->file('logo')->store('company-logos', 'public');
        } else {
            $logoPath = $company->logo;
        }
        
        // Update company
        $company->update([
            'name' => $request->name,
            'description' => $request->description,
            'logo' => $logoPath,
            'website' => $request->website,
            'location' => $request->location,
            'industry' => $request->industry,
            'size' => $request->size,
            'founded_year' => $request->founded_year,
        ]);
        
        return redirect()->route('employer.companies.index')
            ->with('success', 'Company profile updated successfully.');
    }
    
    /**
     * Remove the specified company from storage
     */
    public function destroy($id)
    {
        $company = Company::where('user_id', auth()->id())
            ->findOrFail($id);
        
        // Delete company logo if exists
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }
        
        $company->delete();
        
        return redirect()->route('employer.companies.index')
            ->with('success', 'Company profile deleted successfully.');
    }
}