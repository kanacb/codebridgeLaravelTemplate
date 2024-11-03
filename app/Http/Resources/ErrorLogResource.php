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
        return [
            '_id' => $this->id,
            'serviceName' => $this->serviceName,
            'errorMessage' => $this->errorMessage,
            'message' => $this->message,
            'stack' => $this->stack,
            'details' => $this->details
        ];
    }
}
