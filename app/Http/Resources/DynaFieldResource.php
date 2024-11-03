<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DynaFieldResource extends JsonResource
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
'dynaLoader' => $this->dynaLoader,
'from' => $this->from,
'fromType' => $this->fromType,
'to2' => $this->to2,
'toType' => $this->toType,
'fromRefService' => $this->fromRefService,
'toRefService' => $this->toRefService,
'fromIdentityFieldName' => $this->fromIdentityFieldName,
'toIdentityFieldName' => $this->toIdentityFieldName,
'fromRelationship' => $this->fromRelationship,
'toRelationship' => $this->toRelationship,
'duplicates' => $this->duplicates
        ];
    }
}
