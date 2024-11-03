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
            'phone' => $this->phone
        ];
    }
}
