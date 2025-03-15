<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // For store method, only employers without companies can access
        if ($this->isMethod('post')) {
            return auth()->check() && 
                   auth()->user()->isEmployer() && 
                   !auth()->user()->company;
        }
        
        // For update method, only company owner or admin can access
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $company = $this->route('company');
            return auth()->check() && 
                   (auth()->id() === $company->user_id || auth()->user()->isAdmin());
        }
        
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'nullable|image|max:2048', // max 2MB
            'website' => 'nullable|url|max:255',
            'location' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'size' => 'nullable|string|max:50',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Company name is required',
            'description.required' => 'Company description is required',
            'logo.image' => 'Logo must be an image file',
            'logo.max' => 'Logo size must not exceed 2MB',
            'website.url' => 'Website must be a valid URL',
            'location.required' => 'Company location is required',
            'industry.required' => 'Industry field is required',
            'founded_year.integer' => 'Founded year must be an integer',
            'founded_year.min' => 'Founded year must be at least 1800',
            'founded_year.max' => 'Founded year must be in the past',
        ];
    }
}