<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
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
            'departmentId' => $this->departmentId,
            'name' => $this->name,
            'code' => $this->code,
            'isDefault' => $this->isDefault
        ];
    }
}
