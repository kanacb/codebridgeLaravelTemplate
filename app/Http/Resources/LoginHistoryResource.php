<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginHistoryResource extends JsonResource
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
'userId' => $dField->userId,
'loginTime' => $dField->loginTime,
                        'createdAt' => $dField->created_at,
                        'updatedAt' => $dField->updated_at,
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
'userId' => $this->userId,
'loginTime' => $this->loginTime,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
