<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
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
            'empNo' => 'required|string',
            'name' => 'required|string',
            'fullname' => 'required|string',
            'company' => 'string',
            'department' => 'string',
            'section' => 'string',
            'position' => 'string',
            'supervisor' => 'string',
            'dateJoined' => 'date',
            'dateTerminated' => 'date',
            'resigned' => 'required|string',
            'empGroup' => 'required|string',
            'empCode' => 'required|string'
        ];
    }
}
