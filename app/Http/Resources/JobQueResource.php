<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobQueResource extends JsonResource
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
'fromService' => $this->fromService,
'toService' => $this->toService,
'start' => $this->start,
'end' => $this->end
        ];
    }
}
