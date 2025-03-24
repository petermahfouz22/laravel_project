<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResumeRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role === 'candidate';
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'is_default' => 'nullable|boolean',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->hasFile('file_path')) {
            $this->merge(['file_path' => $this->file('file_path')->store('resumes', 'public')]);
        }
    }
}