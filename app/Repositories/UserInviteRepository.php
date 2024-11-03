<?php

namespace App\Repositories;

use App\Interfaces\UserInviteRepositoryInterface;
use App\Models\UserInvite;
use App\Http\Resources\UserInviteResource;

class UserInviteRepository implements UserInviteRepositoryInterface 
{
    public function getAllUserInvites() 
    {
        $userInvites = UserInvite::all();
        return UserInviteResource::collection($userInvites);
    }

    public function getUserInviteById($UserInviteId) 
    {
        $userInvites = UserInvite::findOrFail($UserInviteId);
        return UserInviteResource::collection($userInvites);
    }

    public function deleteUserInvite($UserInviteId) 
    {
        UserInvite::destroy($UserInviteId);
    }

    public function createUserInvite(array $UserInviteDetails) 
    {
        return UserInvite::create($UserInviteDetails);
    }

    public function updateUserInvite($UserInviteId, array $newDetails) 
    {
        return UserInvite::whereId($UserInviteId)->update($newDetails);
    }

}