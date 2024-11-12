<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginResource extends JsonResource
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
                        'loginEmail' => $dField->loginEmail,
                        'access' => $dField->access,
                        'sendMailCounter' => $dField->sendMailCounter,
                        'code' => $dField->code,
                        'createdAt' => $dField->created_at,
                        'updatedAt' => $dField->updated_at,
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
            'loginEmail' => $this->loginEmail,
            'access' => $this->access,
            'sendMailCounter' => $this->sendMailCounter,
            'code' => $this->code,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
