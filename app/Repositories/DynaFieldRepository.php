<?php

namespace App\Repositories;

use App\Interfaces\DynaFieldRepositoryInterface;
use App\Models\DynaField;
use App\Http\Resources\DynaFieldResource;

class DynaFieldRepository implements DynaFieldRepositoryInterface 
{
    public function getAllDynaFields() 
    {
        $dynaFields = DynaField::all();
        return DynaFieldResource::collection($dynaFields);
    }

    public function getDynaFieldById($DynaFieldId) 
    {
        $dynaFields = DynaField::findOrFail($DynaFieldId);
        return DynaFieldResource::collection($dynaFields);
    }

    public function deleteDynaField($DynaFieldId) 
    {
        DynaField::destroy($DynaFieldId);
    }

    public function createDynaField(array $DynaFieldDetails) 
    {
        return DynaField::create($DynaFieldDetails);
    }

    public function updateDynaField($DynaFieldId, array $newDetails) 
    {
        return DynaField::whereId($DynaFieldId)->update($newDetails);
    }

}