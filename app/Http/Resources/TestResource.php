<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
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
'stack' => $dField->stack,
'service' => $dField->service,
'passed' => $dField->passed,
'failed' => $dField->failed,
'notes' => $dField->notes
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
            '_id' => $this->id,
'stack' => $this->stack,
'service' => $this->service,
'passed' => $this->passed,
'failed' => $this->failed,
'notes' => $this->notes
        ];
    }
}
