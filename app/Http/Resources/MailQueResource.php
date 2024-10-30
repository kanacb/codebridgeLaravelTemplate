<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MailQueResource extends JsonResource
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
'type' => $dField->type,
'data' => $dField->data,
'from' => $dField->from,
'recipients' => $dField->recipients,
'status' => $dField->status,
'errors' => $dField->errors,
'template' => $dField->template,
'content' => $dField->content
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
            '_id' => $this->id,
'name' => $this->name,
'type' => $this->type,
'data' => $this->data,
'from' => $this->from,
'recipients' => $this->recipients,
'status' => $this->status,
'errors' => $this->errors,
'template' => $this->template,
'content' => $this->content
        ];
    }
}
