<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateErrorLogRequest extends FormRequest
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
            'serviceName' => 'required|string',
            'errorMessage' => 'required|string',
            'message' => 'required|string',
            'stack' => 'required|string',
            'details' => 'required|string'
        ];
    }
}
