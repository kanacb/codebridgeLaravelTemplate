<?php

namespace App\Repositories;

use App\Interfaces\DynaLoaderRepositoryInterface;
use App\Models\DynaLoader;
use App\Http\Resources\DynaLoaderResource;

class DynaLoaderRepository implements DynaLoaderRepositoryInterface 
{
    public function getAllDynaLoaders() 
    {
        $dynaLoader = DynaLoader::all();
        return DynaLoaderResource::collection($dynaLoader);
    }

    public function getDynaLoaderById($DynaLoaderId) 
    {
        $dynaLoader = DynaLoader::findOrFail($DynaLoaderId);
        return DynaLoaderResource::collection($dynaLoader);
    }

    public function deleteDynaLoader($DynaLoaderId) 
    {
        DynaLoader::destroy($DynaLoaderId);
    }

    public function createDynaLoader(array $DynaLoaderDetails) 
    {
        return DynaLoader::create($DynaLoaderDetails);
    }

    public function updateDynaLoader($DynaLoaderId, array $newDetails) 
    {
        return DynaLoader::whereId($DynaLoaderId)->update($newDetails);
    }

}