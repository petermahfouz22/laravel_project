<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role === 'candidate';
    }

    public function rules()
    {
        return [
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->hasFile('profile_image')) {
            $this->merge(['profile_image' => $this->file('profile_image')->store('profiles', 'public')]);
}
}
}
