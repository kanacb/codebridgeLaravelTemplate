<?php

namespace App\Interfaces;

interface PermissionFieldRepositoryInterface 
{
    public function getAllPermissionFields();
    public function getPermissionFieldById($permissionFieldId);
    public function deletePermissionField($permissionFieldId);
    public function createPermissionField(array $permissionFieldDetails);
    public function updatePermissionField($permissionFieldId, array $newDetails);
}