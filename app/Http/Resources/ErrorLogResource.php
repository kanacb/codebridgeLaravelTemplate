<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->resource instanceof \Illuminate\Support\Collection) {
            return [
                $this->resource->map(function ($dField) {
                    return [
                        '_id' => $dField->id,
'serviceName' => $dField->serviceName,
'errorMessage' => $dField->errorMessage,
'message' => $dField->message,
'stack' => $dField->stack,
'details' => $dField->details,
                        'createdAt' => $dField->created_at,
                        'updatedAt' => $dField->updated_at,
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
'serviceName' => $this->serviceName,
'errorMessage' => $this->errorMessage,
'message' => $this->message,
'stack' => $this->stack,
'details' => $this->details,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
