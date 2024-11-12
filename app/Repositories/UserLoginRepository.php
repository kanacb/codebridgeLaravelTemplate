<?php

namespace App\Repositories;

use App\Interfaces\UserLoginRepositoryInterface;
use App\Models\UserLogin;
use App\Http\Resources\UserLoginResource;

class UserLoginRepository implements UserLoginRepositoryInterface 
{
    public function getAllUserLogins() 
    {
        $userLogins = UserLogin::all();
        return UserLoginResource::collection($userLogins);
    }

    public function getUserLoginById($UserLoginId) 
    {
        $userLogins = UserLogin::findOrFail($UserLoginId);
        return UserLoginResource::collection($userLogins);
    }

    public function deleteUserLogin($UserLoginId) 
    {
        UserLogin::destroy($UserLoginId);
    }

    public function createUserLogin(array $UserLoginDetails) 
    {
        return UserLogin::create($UserLoginDetails);
    }

    public function updateUserLogin($UserLoginId, array $newDetails) 
    {
        return UserLogin::whereId($UserLoginId)->update($newDetails);
    }

}