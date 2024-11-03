<?php

namespace App\Repositories;

use App\Interfaces\ProfileRepositoryInterface;
use App\Models\Profile;
use App\Http\Resources\ProfileResource;

class ProfileRepository implements ProfileRepositoryInterface 
{
    public function getAllProfiles() 
    {
        $profiles = Profile::all();
        return ProfileResource::collection($profiles);
    }

    public function getProfileById($ProfileId) 
    {
        $profiles = Profile::findOrFail($ProfileId);
        return ProfileResource::collection($profiles);
    }

    public function deleteProfile($ProfileId) 
    {
        Profile::destroy($ProfileId);
    }

    public function createProfile(array $ProfileDetails) 
    {
        return Profile::create($ProfileDetails);
    }

    public function updateProfile($ProfileId, array $newDetails) 
    {
        return Profile::whereId($ProfileId)->update($newDetails);
    }

}