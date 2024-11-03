<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffinfoResource extends JsonResource
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
            'empno' => $this->empno,
            'name' => $this->name,
            'namenric' => $this->namenric,
            'compcode' => $this->compcode,
            'compname' => $this->compname,
            'deptcode' => $this->deptcode,
            'deptdesc' => $this->deptdesc,
            'sectcode' => $this->sectcode,
            'sectdesc' => $this->sectdesc,
            'designation' => $this->designation,
            'email' => $this->email,
            'resign' => $this->resign,
            'supervisor' => $this->supervisor,
            'datejoin' => $this->datejoin,
            'empgroup' => $this->empgroup,
            'empgradecode' => $this->empgradecode,
            'terminationdate' => $this->terminationdate
        ];
    }
}
