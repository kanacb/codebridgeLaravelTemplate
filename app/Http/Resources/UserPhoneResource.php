<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPhoneResource extends JsonResource
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
'userId' => $dField->userId,
'countryCode' => $dField->countryCode,
'operatorCode' => $dField->operatorCode,
'number' => $dField->number,
'type' => $dField->type,
'isDefault' => $dField->isDefault,
                        'createdAt' => $dField->created_at,
                        'updatedAt' => $dField->updated_at,
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
'userId' => $this->userId,
'countryCode' => $this->countryCode,
'operatorCode' => $this->operatorCode,
'number' => $this->number,
'type' => $this->type,
'isDefault' => $this->isDefault,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
