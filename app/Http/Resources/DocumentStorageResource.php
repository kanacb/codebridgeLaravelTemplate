<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentStorageResource extends JsonResource
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
            'size' => $this->size,
            'path' => $this->path,
            'lastModifiedDate' => $this->lastModifiedDate,
            'lastModified' => $this->lastModified,
            'eTag' => $this->eTag,
            'url' => $this->url,
            'tableId' => $this->tableId,
            'tableName' => $this->tableName
        ];
    }
}
