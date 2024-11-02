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
            'Street1' => 'string|max:250',
            'Street2' => 'string|max:250',
            'Poscode' => 'string|max:250',
            'City' => 'string|max:250',
            'State' => 'string|max:250',
            'Province' => 'string|max:250',
            'Country' => 'string|max:250'
        ];
    }
}
