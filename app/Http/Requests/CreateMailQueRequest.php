<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMailQueRequest extends FormRequest
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
            'name' => 'required|min:3|string|max:250',
            'type' => 'required|min:3|string|max:250',
            'data' => 'required|min:3|string|max:250',
            'from' => 'required|min:3|string|max:250',
            'recipients' => 'required|min:3|string|max:250',
            'status' => 'required|min:3|string|max:250',
            'errors' => 'required|min:3|string|max:250',
            'template' => 'required|min:3|string|max:250',
            'content' => 'required|min:3|string|max:250'
        ];
    }
}
