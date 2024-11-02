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
            'from' => 'string|max:250',
            'to2' => 'string|max:250',
            'toType' => 'string|max:250',
            'fromRefService' => 'string|max:250',
            'toRefService' => 'string|max:250',
            'fromIdentityFieldName' => 'string|max:250',
            'toIdentityFieldName' => 'string|max:250',
            'fromRelationship' => 'string|max:250',
            'toRelationship' => 'string|max:250'
        ];
    }
}
