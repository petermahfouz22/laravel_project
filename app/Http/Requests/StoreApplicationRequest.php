<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role === 'candidate';
    }

    public function rules()
    {
        return [
            'job_id' => 'required|exists:jobs,id',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|string|max:2000',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $job = \App\Models\Job::find($this->job_id);
            if ($job && (!$job->is_active || !$job->is_approved || now()->gt($job->application_deadline))) {
                $validator->errors()->add('job_id', 'This job is no longer accepting applications.');
            }
        });
    }

    protected function prepareForValidation()
    {
        if ($this->hasFile('resume')) {
            $this->merge(['resume' => $this->file('resume')->store('resumes', 'public')]);
        }
    }
}