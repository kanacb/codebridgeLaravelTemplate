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
        return [
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
