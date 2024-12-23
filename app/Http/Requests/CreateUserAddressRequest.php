<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserAddressRequest extends FormRequest
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
            'userId' => 'string',
            'Street1' => 'string',
            'Street2' => 'string',
            'Poscode' => 'string',
            'City' => 'string',
            'State' => 'string',
            'Province' => 'string',
            'Country' => 'string'
        ];
    }
}
