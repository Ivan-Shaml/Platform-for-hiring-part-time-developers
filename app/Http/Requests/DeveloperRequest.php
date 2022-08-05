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
            'name' => 'required|max:255',
            'email' => 'nullable',
            'phone' => 'nullable',
            'location' => 'nullable',
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'price_per_hour' => 'nullable',
            'technology' => 'nullable',
            'description' => 'nullable',
            'years_of_experience' => 'nullable',
            'native_language' => 'nullable',
            'linkedin_profile_link' => 'nullable',
        ];
    }
}
