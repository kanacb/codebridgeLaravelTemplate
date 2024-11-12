<?php

namespace App\Repositories;

use App\Interfaces\UserGuideStepRepositoryInterface;
use App\Models\UserGuideStep;
use App\Http\Resources\UserGuideStepResource;

class UserGuideStepRepository implements UserGuideStepRepositoryInterface 
{
    public function getAllUserGuideSteps() 
    {
        $userGuideSteps = UserGuideStep::all();
        return UserGuideStepResource::collection($userGuideSteps);
    }

    public function getUserGuideStepById($UserGuideStepId) 
    {
        $userGuideSteps = UserGuideStep::findOrFail($UserGuideStepId);
        return UserGuideStepResource::collection($userGuideSteps);
    }

    public function deleteUserGuideStep($UserGuideStepId) 
    {
        UserGuideStep::destroy($UserGuideStepId);
    }

    public function createUserGuideStep(array $UserGuideStepDetails) 
    {
        return UserGuideStep::create($UserGuideStepDetails);
    }

    public function updateUserGuideStep($UserGuideStepId, array $newDetails) 
    {
        return UserGuideStep::whereId($UserGuideStepId)->update($newDetails);
    }

}