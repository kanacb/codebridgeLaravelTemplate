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
        return [
            '_id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'data' => $this->data,
            'from' => $this->from,
            'recipients' => $this->recipients,
            'status' => $this->status,
            'errors' => $this->errors,
            'templateId' => $this->templateId,
            'content' => $this->content
        ];
    }
}
