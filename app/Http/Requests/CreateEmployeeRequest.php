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
            'empNo' => 'required|min:3|string|max:250',
            'name' => 'required|min:3|string|max:250',
            'fullname' => 'required|min:3|string|max:250',
            'resigned' => 'required|min:3|string|max:250',
            'empGroup' => 'required|min:3|string|max:250',
            'empCode' => 'required|min:3|string|max:250'
        ];
    }
}
