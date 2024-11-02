<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStaffinfoRequest extends FormRequest
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
            'name' => 'string|max:250',
            'namenric' => 'string|max:250',
            'compname' => 'string|max:250',
            'deptcode' => 'string|max:250',
            'deptdesc' => 'string|max:250',
            'sectdesc' => 'string|max:250',
            'designation' => 'string|max:250',
            'email' => 'string|max:250',
            'resign' => 'string|max:250',
            'supervisor' => 'string|max:250',
            'empgroup' => 'string|max:250',
            'empgradecode' => 'string|max:250',
            'terminationdate' => 'string|max:250'
        ];
    }
}
