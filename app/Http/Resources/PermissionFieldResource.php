<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionFieldResource extends JsonResource
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
'profile' => $dField->profile,
'service' => $dField->service,
'fieldId' => $dField->fieldId,
'read' => $dField->read,
'readAll' => $dField->readAll,
'updateOwn' => $dField->updateOwn,
'updateAll' => $dField->updateAll,
'deleteOwn' => $dField->deleteOwn,
'deleteAll' => $dField->deleteAll
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
            '_id' => $this->id,
'profile' => $this->profile,
'service' => $this->service,
'fieldId' => $this->fieldId,
'read' => $this->read,
'readAll' => $this->readAll,
'updateOwn' => $this->updateOwn,
'updateAll' => $this->updateAll,
'deleteOwn' => $this->deleteOwn,
'deleteAll' => $this->deleteAll
        ];
    }
}
