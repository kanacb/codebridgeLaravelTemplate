<?php

namespace App\Repositories;

use App\Interfaces\DepartmentHODRepositoryInterface;
use App\Models\DepartmentHOD;
use App\Http\Resources\DepartmentHODResource;

class DepartmentHODRepository implements DepartmentHODRepositoryInterface 
{
    public function getAllDepartmentHODS() 
    {
        $departmentHOD = DepartmentHOD::all();
        return DepartmentHODResource::collection($departmentHOD);
    }

    public function getDepartmentHODById($DepartmentHODId) 
    {
        $departmentHOD = DepartmentHOD::findOrFail($DepartmentHODId);
        return DepartmentHODResource::collection($departmentHOD);
    }

    public function deleteDepartmentHOD($DepartmentHODId) 
    {
        DepartmentHOD::destroy($DepartmentHODId);
    }

    public function createDepartmentHOD(array $DepartmentHODDetails) 
    {
        return DepartmentHOD::create($DepartmentHODDetails);
    }

    public function updateDepartmentHOD($DepartmentHODId, array $newDetails) 
    {
        return DepartmentHOD::whereId($DepartmentHODId)->update($newDetails);
    }

}