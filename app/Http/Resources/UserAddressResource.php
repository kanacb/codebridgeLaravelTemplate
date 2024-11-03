<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
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
            'userId' => $this->userId,
            'Street1' => $this->Street1,
            'Street2' => $this->Street2,
            'Poscode' => $this->Poscode,
            'City' => $this->City,
            'State' => $this->State,
            'Province' => $this->Province,
            'Country' => $this->Country
        ];
    }
}
