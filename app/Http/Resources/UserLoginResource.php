<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginResource extends JsonResource
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
            'loginEmail' => $this->loginEmail,
            'access' => $this->access,
            'sendMailCounter' => $this->sendMailCounter,
            'code' => $this->code
        ];
    }
}
