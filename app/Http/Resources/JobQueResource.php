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
'fromService' => $dField->fromService,
'toService' => $dField->toService,
'start' => $dField->start,
'end' => $dField->end
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
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
