<?php

namespace App\Interfaces;

interface DepartmentHODRepositoryInterface 
{
    public function getAllDepartmentHODS();
    public function getDepartmentHODById($departmentHODId);
    public function deleteDepartmentHOD($departmentHODId);
    public function createDepartmentHOD(array $departmentHODDetails);
    public function updateDepartmentHOD($departmentHODId, array $newDetails);
}