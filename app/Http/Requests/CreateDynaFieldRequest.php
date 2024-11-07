<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDynaFieldRequest extends FormRequest
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
            'dynaLoader' => 'required|string',
'from' => 'string',
'fromType' => 'required|string',
'to2' => 'string',
'toType' => 'string',
'fromRefService' => 'string',
'toRefService' => 'string',
'fromIdentityFieldName' => 'string',
'toIdentityFieldName' => 'string',
'fromRelationship' => 'string',
'toRelationship' => 'string',
'duplicates' => 'required|boolean'
        ];
    }
}
