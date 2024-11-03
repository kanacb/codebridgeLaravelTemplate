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
            'name' => 'string',
'namenric' => 'string',
'compname' => 'string',
'deptcode' => 'string',
'deptdesc' => 'string',
'sectdesc' => 'string',
'designation' => 'string',
'email' => 'string',
'resign' => 'string',
'supervisor' => 'string',
'empgroup' => 'string',
'empgradecode' => 'string',
'terminationdate' => 'string'
        ];
    }
}
