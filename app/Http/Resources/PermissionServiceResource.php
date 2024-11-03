<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionServiceResource extends JsonResource
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
'profile' => $this->profile,
'service' => $this->service,
'read' => $this->read,
'readAll' => $this->readAll,
'updateOwn' => $this->updateOwn,
'updateAll' => $this->updateAll,
'deleteOwn' => $this->deleteOwn,
'deleteAll' => $this->deleteAll
        ];
    }
}
