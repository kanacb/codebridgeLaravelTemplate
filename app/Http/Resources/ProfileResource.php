<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
'userId' => $dField->userId,
'image' => $dField->image,
'bio' => $dField->bio,
'department' => $dField->department,
'hod' => $dField->hod,
'section' => $dField->section,
'hos' => $dField->hos,
'position' => $dField->position,
'manager' => $dField->manager,
'company' => $dField->company,
'branch' => $dField->branch,
'skills' => $dField->skills,
'address' => $dField->address,
'phone' => $dField->phone,
                        'createdAt' => $dField->created_at,
                        'updatedAt' => $dField->updated_at,
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
'name' => $this->name,
'userId' => $this->userId,
'image' => $this->image,
'bio' => $this->bio,
'department' => $this->department,
'hod' => $this->hod,
'section' => $this->section,
'hos' => $this->hos,
'position' => $this->position,
'manager' => $this->manager,
'company' => $this->company,
'branch' => $this->branch,
'skills' => $this->skills,
'address' => $this->address,
'phone' => $this->phone,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
