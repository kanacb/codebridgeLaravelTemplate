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
        if ($this->resource instanceof \Illuminate\Support\Collection) {
            return [
                $this->resource->map(function ($dField) {
                    return [
                        '_id' => $dField->id,
                        'name' => $dField->name,
                        'size' => $dField->size,
                        'path' => $dField->path,
                        'lastModifiedDate' => $dField->lastModifiedDate,
                        'lastModified' => $dField->lastModified,
                        'eTag' => $dField->eTag,
                        'url' => $dField->url,
                        'tableId' => $dField->tableId,
                        'tableName' => $dField->tableName,
                        'createdAt' => $dField->created_at,
                        'updatedAt' => $dField->updated_at,
                    ];
                }),
            ];
        } else if (is_int($this->resource)) return [];
        else
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
                'tableName' => $this->tableName,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at
            ];
    }
}
