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
        if ($this->resource instanceof \Illuminate\Support\Collection) {
            return [
                'total' => $this->resource->count(),
                'limit' => 0,
                'skip' => 0,
                'data' => $this->resource->map(function ($dField) {
                    return [
                        '_id' => $this->id,
                        '_id' => $dField->id,
'dynaLoader' => $dField->dynaLoader,
'from' => $dField->from,
'fromType' => $dField->fromType,
'to2' => $dField->to2,
'toType' => $dField->toType,
'fromRefService' => $dField->fromRefService,
'toRefService' => $dField->toRefService,
'fromIdentityFieldName' => $dField->fromIdentityFieldName,
'toIdentityFieldName' => $dField->toIdentityFieldName,
'fromRelationship' => $dField->fromRelationship,
'toRelationship' => $dField->toRelationship,
'duplicates' => $dField->duplicates
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
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
