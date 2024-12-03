<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                        'email' => $dField->email,
                        'status' => $this->status == 1 ? true : false,
                        'email_verified_at' => $this->email_verified_at == 1 ? true : false,
                        'remember_token' => $dField->remember_token,
                        'createdAt' => $dField->created_at,
                        'updatedAt' => $dField->updated_at,
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status == 1 ? true : false,
            'email_verified_at' => $this->email_verified_at == 1 ? true : false,
            'remember_token' => $this->remember_token,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
