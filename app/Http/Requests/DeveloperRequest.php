<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeveloperRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'email' => 'required|unique:developers,email,'.$this->id,
            'phone' => 'nullable|numeric|digits:10',
            'location' => 'nullable',
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'price_per_hour' => 'nullable|integer|min:1|max:100',
            'technology' => 'nullable',
            'description' => 'nullable',
            'years_of_experience' => 'nullable|integer|min:1|max:100',
            'native_language' => 'nullable',
            'linkedin_profile_link' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name is required.',
            'email.required' => 'Invalid email value.',
            'email.unique' => 'Email must be unique.',
            'phone.required' => 'Phone number must be 10 digits.',
        ];
    }
}
