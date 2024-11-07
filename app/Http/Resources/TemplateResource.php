<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
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
'subject' => $dField->subject,
'body' => $dField->body,
'image' => $dField->image,
                        'createdAt' => $dField->created_at,
                        'updatedAt' => $dField->updated_at,
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
'name' => $this->name,
'subject' => $this->subject,
'body' => $this->body,
'image' => $this->image,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
