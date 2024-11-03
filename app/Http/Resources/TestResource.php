<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
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
            'stack' => $this->stack,
            'service' => $this->service,
            'passed' => $this->passed,
            'failed' => $this->failed,
            'notes' => $this->notes
        ];
    }
}
