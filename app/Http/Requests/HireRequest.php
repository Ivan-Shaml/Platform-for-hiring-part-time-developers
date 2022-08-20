<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HireRequest extends FormRequest
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
            'names' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ];
    }


    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'names.required' => 'Choosing at least one developer is required!',
            'start_date.required' => 'Start Date is required!',
            'end_date.required' => 'End Date is required!'
        ];
    }
}
