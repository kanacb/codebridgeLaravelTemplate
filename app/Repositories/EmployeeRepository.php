<?php

namespace App\Repositories;

use App\Interfaces\EmployeeRepositoryInterface;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;

class EmployeeRepository implements EmployeeRepositoryInterface 
{
    public function getAllEmployees() 
    {
        $employees = Employee::all();
        return EmployeeResource::collection($employees);
    }

    public function getEmployeeById($EmployeeId) 
    {
        $employees = Employee::findOrFail($EmployeeId);
        return EmployeeResource::collection($employees);
    }

    public function deleteEmployee($EmployeeId) 
    {
        Employee::destroy($EmployeeId);
    }

    public function createEmployee(array $EmployeeDetails) 
    {
        return Employee::create($EmployeeDetails);
    }

    public function updateEmployee($EmployeeId, array $newDetails) 
    {
        return Employee::whereId($EmployeeId)->update($newDetails);
    }

}