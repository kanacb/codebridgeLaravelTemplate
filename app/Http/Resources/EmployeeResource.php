<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
'empNo' => $dField->empNo,
'name' => $dField->name,
'fullname' => $dField->fullname,
'company' => $dField->company,
'department' => $dField->department,
'section' => $dField->section,
'position' => $dField->position,
'supervisor' => $dField->supervisor,
'dateJoined' => $dField->dateJoined,
'dateTerminated' => $dField->dateTerminated,
'resigned' => $dField->resigned,
'empGroup' => $dField->empGroup,
'empCode' => $dField->empCode
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
            '_id' => $this->id,
'empNo' => $this->empNo,
'name' => $this->name,
'fullname' => $this->fullname,
'company' => $this->company,
'department' => $this->department,
'section' => $this->section,
'position' => $this->position,
'supervisor' => $this->supervisor,
'dateJoined' => $this->dateJoined,
'dateTerminated' => $this->dateTerminated,
'resigned' => $this->resigned,
'empGroup' => $this->empGroup,
'empCode' => $this->empCode
        ];
    }
}
