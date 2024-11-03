<?php

namespace App\Repositories;

use App\Interfaces\DepartmentRepositoryInterface;
use App\Models\Department;
use App\Http\Resources\DepartmentResource;

class DepartmentRepository implements DepartmentRepositoryInterface 
{
    public function getAllDepartments() 
    {
        $departments = Department::all();
        return DepartmentResource::collection($departments);
    }

    public function getDepartmentById($DepartmentId) 
    {
        $departments = Department::findOrFail($DepartmentId);
        return DepartmentResource::collection($departments);
    }

    public function deleteDepartment($DepartmentId) 
    {
        Department::destroy($DepartmentId);
    }

    public function createDepartment(array $DepartmentDetails) 
    {
        return Department::create($DepartmentDetails);
    }

    public function updateDepartment($DepartmentId, array $newDetails) 
    {
        return Department::whereId($DepartmentId)->update($newDetails);
    }

}