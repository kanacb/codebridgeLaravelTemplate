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
                'total' => $this->resource->count(),
                'limit' => 0,
                'skip' => 0,
                'data' => $this->resource->map(function ($dField) {
                    return [
                        '_id' => $this->id,
                        '_id' => $dField->id,
'companyId' => $dField->companyId,
'Street1' => $dField->Street1,
'Street2' => $dField->Street2,
'Poscode' => $dField->Poscode,
'City' => $dField->City,
'State' => $dField->State,
'Province' => $dField->Province,
'Country' => $dField->Country,
'isDefault' => $dField->isDefault
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
            '_id' => $this->id,
'companyId' => $this->companyId,
'Street1' => $this->Street1,
'Street2' => $this->Street2,
'Poscode' => $this->Poscode,
'City' => $this->City,
'State' => $this->State,
'Province' => $this->Province,
'Country' => $this->Country,
'isDefault' => $this->isDefault
        ];
    }
}
