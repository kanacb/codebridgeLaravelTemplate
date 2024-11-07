<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePermissionFieldRequest extends FormRequest
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
            'profile' => 'string',
'service' => 'string',
'fieldId' => 'string',
'read' => 'boolean',
'readAll' => 'boolean',
'updateOwn' => 'boolean',
'updateAll' => 'boolean',
'deleteOwn' => 'boolean',
'deleteAll' => 'boolean'
        ];
    }
}
