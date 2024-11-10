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
            'name' => 'required|string',
            'type' => 'required|string',
            'data' => 'bail|required|json',
            'from' => 'required|string',
            'recipients' => 'bail|required|json',
            'status' => 'boolean',
            'subject' => 'required|string',
            'errors' => 'string',
            'templateId' => 'required|string',
            'content' => 'string'
        ];
    }

    protected function prepareForValidation()
    {
        // Convert data_field to JSON if it is an array
        if (is_array($this->data) || is_object($this->data)) {
            $this->merge([
                'data' => json_encode($this->data),
            ]);
        }

        if (is_array($this->recipients)) {
            $this->merge([
                'recipients' => json_encode($this->recipients)
            ]);
        }
    }
}
