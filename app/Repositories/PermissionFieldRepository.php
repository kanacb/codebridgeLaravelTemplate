<?php

namespace App\Repositories;

use App\Interfaces\PermissionFieldRepositoryInterface;
use App\Models\PermissionField;
use App\Http\Resources\PermissionFieldResource;

class PermissionFieldRepository implements PermissionFieldRepositoryInterface 
{
    public function getAllPermissionFields() 
    {
        $permissionFields = PermissionField::all();
        return PermissionFieldResource::collection($permissionFields);
    }

    public function getPermissionFieldById($PermissionFieldId) 
    {
        $permissionFields = PermissionField::findOrFail($PermissionFieldId);
        return PermissionFieldResource::collection($permissionFields);
    }

    public function deletePermissionField($PermissionFieldId) 
    {
        PermissionField::destroy($PermissionFieldId);
    }

    public function createPermissionField(array $PermissionFieldDetails) 
    {
        return PermissionField::create($PermissionFieldDetails);
    }

    public function updatePermissionField($PermissionFieldId, array $newDetails) 
    {
        return PermissionField::whereId($PermissionFieldId)->update($newDetails);
    }

}