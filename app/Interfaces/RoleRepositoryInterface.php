<?php

namespace App\Interfaces;

interface RoleRepositoryInterface 
{
    public function getAllRoles();
    public function getRoleById($roleId);
    public function deleteRole($roleId);
    public function createRole(array $roleDetails);
    public function updateRole($roleId, array $newDetails);
}