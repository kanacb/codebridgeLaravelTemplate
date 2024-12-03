<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInviteResource extends JsonResource
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
                        'emailToInvite' => $dField->emailToInvite,
                        'status' => $dField->status,
                        'code' => $dField->code,
                        'sendMailCounter' => $dField->sendMailCounter
                    ];
                }),
            ];
        } else if (is_int($this->resource)) return [];
        else
            return [
                '_id' => $this->id,
                'emailToInvite' => $this->emailToInvite,
                'status' => $this->status,
                'code' => $this->code,
                'sendMailCounter' => $this->sendMailCounter
            ];
    }
}
