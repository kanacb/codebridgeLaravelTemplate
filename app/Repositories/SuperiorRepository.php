<?php

namespace App\Repositories;

use App\Interfaces\SuperiorRepositoryInterface;
use App\Models\Superior;
use App\Http\Resources\SuperiorResource;

class SuperiorRepository implements SuperiorRepositoryInterface 
{
    public function getAllSuperiors() 
    {
        $superior = Superior::all();
        return SuperiorResource::collection($superior);
    }

    public function getSuperiorById($SuperiorId) 
    {
        $superior = Superior::findOrFail($SuperiorId);
        return SuperiorResource::collection($superior);
    }

    public function deleteSuperior($SuperiorId) 
    {
        Superior::destroy($SuperiorId);
    }

    public function createSuperior(array $SuperiorDetails) 
    {
        return Superior::create($SuperiorDetails);
    }

    public function updateSuperior($SuperiorId, array $newDetails) 
    {
        return Superior::whereId($SuperiorId)->update($newDetails);
    }

}