<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
                        'companyId' => $dField->companyId,
                        'name' => $dField->name,
                        'isDefault' => $dField->isDefault,
                        'createdAt' => $dField->created_at,
                        'updatedAt' => $dField->updated_at,
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
            'companyId' => $this->companyId,
            'name' => $this->name,
            'isDefault' => $this->isDefault,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
