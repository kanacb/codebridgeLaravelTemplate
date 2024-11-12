<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProfileRequest extends FormRequest
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
            'name' => 'required|string',
            'userId' => 'string',
            'image' => 'required|string',
            'bio' => 'string',
            'department' => 'required|string',
            'hod' => 'required|boolean',
            'section' => 'string',
            'hos' => 'required|boolean',
            'position' => 'required|string',
            'manager' => 'string',
            'company' => 'required|string',
            'branch' => 'string',
            'skills' => 'string',
            'address' => 'string',
            'phone' => 'string'
        ];
    }
}
