<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
                        'name' => $dField->name,
                        'description' => $dField->description,
                        'isDefault' => $dField->isDefault,
                        'createdAt' => $dField->created_at,
                        'updatedAt' => $dField->updated_at,
                    ];
                }),
            ];
        } else if (is_int($this->resource)) return [];
        else
            return [
                '_id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'isDefault' => $this->isDefault,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at
            ];
    }
}
