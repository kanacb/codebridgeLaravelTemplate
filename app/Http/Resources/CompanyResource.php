<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
'name' => $dField->name,
'companyNo' => $dField->companyNo,
'newCompanyNumber' => $dField->newCompanyNumber,
'DateIncorporated' => $dField->DateIncorporated,
'isdefault' => $dField->isdefault
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
            '_id' => $this->id,
'name' => $this->name,
'companyNo' => $this->companyNo,
'newCompanyNumber' => $this->newCompanyNumber,
'DateIncorporated' => $this->DateIncorporated,
'isdefault' => $this->isdefault
        ];
    }
}
