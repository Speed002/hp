<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHospitalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hospital_name' => 'required|max:255',
            'user_name' => 'required|max:255',
            'user_email' => 'required|email|max:255',
            'user_contact' => 'required|max:255',
            'hospital_address' => 'required|max:255',
            'departments' => 'required|array',
            'departments.*' => 'integer',
            'departments.required' => 'Please select at least one department'
        ];
    }
}
