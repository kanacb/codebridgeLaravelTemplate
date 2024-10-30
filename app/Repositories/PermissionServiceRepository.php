<?php

namespace App\Repositories;

use App\Interfaces\PermissionServiceRepositoryInterface;
use App\Models\PermissionService;
use App\Http\Resources\PermissionServiceResource;

class PermissionServiceRepository implements PermissionServiceRepositoryInterface 
{
    public function getAllPermissionServices() 
    {
        $permissionServices = PermissionService::all();
        return PermissionServiceResource::collection($permissionServices);
    }

    public function getPermissionServiceById($PermissionServiceId) 
    {
        $permissionServices = PermissionService::findOrFail($PermissionServiceId);
        return PermissionServiceResource::collection($permissionServices);
    }

    public function deletePermissionService($PermissionServiceId) 
    {
        PermissionService::destroy($PermissionServiceId);
    }

    public function createPermissionService(array $PermissionServiceDetails) 
    {
        return PermissionService::create($PermissionServiceDetails);
    }

    public function updatePermissionService($PermissionServiceId, array $newDetails) 
    {
        return PermissionService::whereId($PermissionServiceId)->update($newDetails);
    }

}