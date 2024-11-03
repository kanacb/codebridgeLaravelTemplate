<?php

namespace App\Interfaces;

interface PermissionServiceRepositoryInterface 
{
    public function getAllPermissionServices();
    public function getPermissionServiceById($permissionServiceId);
    public function deletePermissionService($permissionServiceId);
    public function createPermissionService(array $permissionServiceDetails);
    public function updatePermissionService($permissionServiceId, array $newDetails);
}