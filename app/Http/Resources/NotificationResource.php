<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
'toUser' => $dField->toUser,
'content' => $dField->content,
'read' => $dField->read,
'sent' => $dField->sent,
                        'createdAt' => $dField->created_at,
                        'updatedAt' => $dField->updated_at,
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
'toUser' => $this->toUser,
'content' => $this->content,
'read' => $this->read,
'sent' => $this->sent,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
