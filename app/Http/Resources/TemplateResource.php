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
                'total' => $this->resource->count(),
                'limit' => 0,
                'skip' => 0,
                'data' => $this->resource->map(function ($dField) {
                    return [
                        '_id' => $this->id,
                        '_id' => $dField->id,
'name' => $dField->name,
'subject' => $dField->subject,
'body' => $dField->body,
'variables' => $dField->variables,
'image' => $dField->image
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
            '_id' => $this->id,
'name' => $this->name,
'subject' => $this->subject,
'body' => $this->body,
'variables' => $this->variables,
'image' => $this->image
        ];
    }
}
