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
                $this->resource->map(function ($dField) {
                    return [
                        '_id' => $dField->id,
                        'name' => $dField->name,
                        'type' => $dField->type,
                        'data' => json_decode($dField->data),
                        'from' => $dField->from,
                        'recipients' => json_decode($dField->recipients),
                        'status' => $dField->status,
                        'errors' => $dField->errors,
                        'templateId' => $dField->templateId,
                        'content' => $dField->content
                    ];
                }),
            ];
        } else if (is_int($this->resource)) return [];
        else
            return [
                '_id' => $this->id,
                'name' => $this->name,
                'type' => $this->type,
                'data' => json_decode($this->data),
                'from' => $this->from,
                'recipients' => json_decode($this->recipients),
                'status' => $this->status,
                'errors' => $this->errors,
                'templateId' => $this->templateId,
                'content' => $this->content
            ];
    }
}
