<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && (auth()->user()->isEmployer() || auth()->user()->isAdmin());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:job_categories,id',
            'description' => 'required|string',
            'responsibilities' => 'required|string',
            'requirements' => 'required|string',
            'benefits' => 'nullable|string',
            'location' => 'required|string|max:255',
            'work_type' => 'required|in:remote,onsite,hybrid',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'technologies' => 'nullable|array',
            'technologies.*' => 'exists:technologies,id',
        ];

        // Add deadline validation with 'after:today' only for job creation
        if ($this->isMethod('post')) {
            $rules['application_deadline'] = 'required|date|after:today';
        } else {
            $rules['application_deadline'] = 'required|date';
            $rules['is_active'] = 'boolean';
        }

        // Admin-only field
        if (auth()->user()->isAdmin()) {
            $rules['is_approved'] = 'boolean';
        }

        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'The job title is required.',
            'category_id.required' => 'Please select a job category.',
            'category_id.exists' => 'The selected category does not exist.',
            'description.required' => 'Job description is required.',
            'responsibilities.required' => 'Job responsibilities are required.',
            'requirements.required' => 'Job requirements are required.',
            'location.required' => 'Job location is required.',
            'work_type.required' => 'Please select a work type.',
            'work_type.in' => 'Work type must be remote, onsite, or hybrid.',
            'salary_max.gte' => 'Maximum salary must be greater than or equal to minimum salary.',
            'application_deadline.required' => 'Application deadline is required.',
            'application_deadline.after' => 'Application deadline must be a future date.',
            'technologies.*.exists' => 'One or more selected technologies do not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        // Convert is_active checkbox to boolean if present
        if ($this->has('is_active')) {
            $this->merge([
                'is_active' => $this->boolean('is_active'),
            ]);
        }

        // Convert is_approved checkbox to boolean if present
        if ($this->has('is_approved')) {
            $this->merge([
                'is_approved' => $this->boolean('is_approved'),
            ]);
        }
    }
}