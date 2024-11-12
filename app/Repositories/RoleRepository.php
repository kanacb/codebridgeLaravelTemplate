<?php

namespace App\Repositories;

use App\Interfaces\RoleRepositoryInterface;
use App\Models\Role;
use App\Http\Resources\RoleResource;

class RoleRepository implements RoleRepositoryInterface 
{
    public function getAllRoles() 
    {
        $roles = Role::all();
        return RoleResource::collection($roles);
    }

    public function getRoleById($RoleId) 
    {
        $roles = Role::findOrFail($RoleId);
        return RoleResource::collection($roles);
    }

    public function deleteRole($RoleId) 
    {
        Role::destroy($RoleId);
    }

    public function createRole(array $RoleDetails) 
    {
        return Role::create($RoleDetails);
    }

    public function updateRole($RoleId, array $newDetails) 
    {
        return Role::whereId($RoleId)->update($newDetails);
    }

}