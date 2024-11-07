<?php

namespace App\Interfaces;

interface DepartmentHORepositoryInterface 
{
    public function getAllDepartmentHOS();
    public function getDepartmentHOById($departmentHOId);
    public function deleteDepartmentHO($departmentHOId);
    public function createDepartmentHO(array $departmentHODetails);
    public function updateDepartmentHO($departmentHOId, array $newDetails);
}