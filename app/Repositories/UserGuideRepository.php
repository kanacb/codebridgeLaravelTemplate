<?php

namespace App\Repositories;

use App\Interfaces\UserGuideRepositoryInterface;
use App\Models\UserGuide;
use App\Http\Resources\UserGuideResource;

class UserGuideRepository implements UserGuideRepositoryInterface 
{
    public function getAllUserGuides() 
    {
        $userGuides = UserGuide::all();
        return UserGuideResource::collection($userGuides);
    }

    public function getUserGuideById($UserGuideId) 
    {
        $userGuides = UserGuide::findOrFail($UserGuideId);
        return UserGuideResource::collection($userGuides);
    }

    public function deleteUserGuide($UserGuideId) 
    {
        UserGuide::destroy($UserGuideId);
    }

    public function createUserGuide(array $UserGuideDetails) 
    {
        return UserGuide::create($UserGuideDetails);
    }

    public function updateUserGuide($UserGuideId, array $newDetails) 
    {
        return UserGuide::whereId($UserGuideId)->update($newDetails);
    }

}