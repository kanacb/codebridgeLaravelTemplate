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
        return [
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
