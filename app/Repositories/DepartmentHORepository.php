<?php

namespace App\Repositories;

use App\Interfaces\DepartmentHORepositoryInterface;
use App\Models\DepartmentHO;
use App\Http\Resources\DepartmentHOResource;

class DepartmentHORepository implements DepartmentHORepositoryInterface 
{
    public function getAllDepartmentHOS() 
    {
        $departmentHOS = DepartmentHO::all();
        return DepartmentHOResource::collection($departmentHOS);
    }

    public function getDepartmentHOById($DepartmentHOId) 
    {
        $departmentHOS = DepartmentHO::findOrFail($DepartmentHOId);
        return DepartmentHOResource::collection($departmentHOS);
    }

    public function deleteDepartmentHO($DepartmentHOId) 
    {
        DepartmentHO::destroy($DepartmentHOId);
    }

    public function createDepartmentHO(array $DepartmentHODetails) 
    {
        return DepartmentHO::create($DepartmentHODetails);
    }

    public function updateDepartmentHO($DepartmentHOId, array $newDetails) 
    {
        return DepartmentHO::whereId($DepartmentHOId)->update($newDetails);
    }

}