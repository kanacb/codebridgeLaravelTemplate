<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PositionResource extends JsonResource
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
            'roleId' => $this->roleId,
            'name' => $this->name,
            'description' => $this->description,
            'abbr' => $this->abbr,
            'isDefault' => $this->isDefault
        ];
    }
}
