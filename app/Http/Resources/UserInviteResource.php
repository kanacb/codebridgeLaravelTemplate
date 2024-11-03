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
        return [
            '_id' => $this->id,
            'emailToInvite' => $this->emailToInvite,
            'status' => $this->status,
            'code' => $this->code,
            'sendMailCounter' => $this->sendMailCounter
        ];
    }
}
