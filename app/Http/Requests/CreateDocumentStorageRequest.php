<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDocumentStorageRequest extends FormRequest
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
            'size' => 'numeric',
            'path' => 'required|string',
            'lastModifiedDate' => 'date',
            'lastModified' => 'date',
            'eTag' => 'required|string',
            'url' => 'required|string',
            'tableId' => 'required|string',
            'tableName' => 'required|string'
        ];
    }
}
