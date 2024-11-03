<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InboxResource extends JsonResource
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
            'from' => $this->from,
            'toUser' => $this->toUser,
            'content' => $this->content,
            'read' => $this->read,
            'sent' => $this->sent
        ];
    }
}
