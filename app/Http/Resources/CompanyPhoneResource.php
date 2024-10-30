<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyPhoneResource extends JsonResource
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
                'total' => $this->resource->count(),
                'limit' => 0,
                'skip' => 0,
                'data' => $this->resource->map(function ($dField) {
                    return [
                        '_id' => $this->id,
                        '_id' => $dField->id,
'companyId' => $dField->companyId,
'countryCode' => $dField->countryCode,
'operatorCode' => $dField->operatorCode,
'number' => $dField->number,
'type' => $dField->type,
'isDefault' => $dField->isDefault
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
            '_id' => $this->id,
'companyId' => $this->companyId,
'countryCode' => $this->countryCode,
'operatorCode' => $this->operatorCode,
'number' => $this->number,
'type' => $this->type,
'isDefault' => $this->isDefault
        ];
    }
}
