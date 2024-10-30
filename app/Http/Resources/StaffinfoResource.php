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
        if ($this->resource instanceof \Illuminate\Support\Collection) {
            return [
                'total' => $this->resource->count(),
                'limit' => 0,
                'skip' => 0,
                'data' => $this->resource->map(function ($dField) {
                    return [
                        '_id' => $this->id,
                        '_id' => $dField->id,
'empno' => $dField->empno,
'name' => $dField->name,
'namenric' => $dField->namenric,
'compcode' => $dField->compcode,
'compname' => $dField->compname,
'deptcode' => $dField->deptcode,
'deptdesc' => $dField->deptdesc,
'sectcode' => $dField->sectcode,
'sectdesc' => $dField->sectdesc,
'designation' => $dField->designation,
'email' => $dField->email,
'resign' => $dField->resign,
'supervisor' => $dField->supervisor,
'datejoin' => $dField->datejoin,
'empgroup' => $dField->empgroup,
'empgradecode' => $dField->empgradecode,
'terminationdate' => $dField->terminationdate
                    ];
                }),
            ];
        }
        return [
            '_id' => $this->id,
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
