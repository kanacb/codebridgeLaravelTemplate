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
                $this->resource->map(function ($dField) {
                    return [
                        '_id' => $dField->id,
                        'name' => $dField->name,
                        'companyNo' => $dField->companyNo,
                        'newCompanyNumber' => $dField->newCompanyNumber,
                        'DateIncorporated' => $dField->DateIncorporated,
                        'isdefault' => $dField->isdefault,
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
                'companyNo' => $this->companyNo,
                'newCompanyNumber' => $this->newCompanyNumber,
                'DateIncorporated' => $this->DateIncorporated,
                'isdefault' => $this->isdefault,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at
            ];
    }
}
