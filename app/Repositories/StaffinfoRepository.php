<?php

namespace App\Repositories;

use App\Interfaces\StaffinfoRepositoryInterface;
use App\Models\Staffinfo;
use App\Http\Resources\StaffinfoResource;

class StaffinfoRepository implements StaffinfoRepositoryInterface 
{
    public function getAllStaffinfos() 
    {
        $staffinfo = Staffinfo::all();
        return StaffinfoResource::collection($staffinfo);
    }

    public function getStaffinfoById($StaffinfoId) 
    {
        $staffinfo = Staffinfo::findOrFail($StaffinfoId);
        return StaffinfoResource::collection($staffinfo);
    }

    public function deleteStaffinfo($StaffinfoId) 
    {
        Staffinfo::destroy($StaffinfoId);
    }

    public function createStaffinfo(array $StaffinfoDetails) 
    {
        return Staffinfo::create($StaffinfoDetails);
    }

    public function updateStaffinfo($StaffinfoId, array $newDetails) 
    {
        return Staffinfo::whereId($StaffinfoId)->update($newDetails);
    }

}