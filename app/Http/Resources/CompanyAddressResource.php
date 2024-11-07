<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyAddressResource extends JsonResource
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
'Street1' => $dField->Street1,
'Street2' => $dField->Street2,
'Poscode' => $dField->Poscode,
'City' => $dField->City,
'State' => $dField->State,
'Province' => $dField->Province,
'Country' => $dField->Country,
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
'Street1' => $this->Street1,
'Street2' => $this->Street2,
'Poscode' => $this->Poscode,
'City' => $this->City,
'State' => $this->State,
'Province' => $this->Province,
'Country' => $this->Country,
'isDefault' => $this->isDefault,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
