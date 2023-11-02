<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserRepository implements UserRepositoryInterface 
{
    public function getAllUsers() 
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function getUserById($userId) 
    {
        $users = User::findOrFail($userId);
        return UserResource::collection($users);
    }

    public function deleteUser($userId) 
    {
        User::destroy($userId);
    }

    public function createUser(array $userDetails) 
    {
        return User::create($userDetails);
    }

    public function updateUser($userId, array $newDetails) 
    {
        $users = User::whereId($userId)->update($newDetails);
        return UserResource::collection($users);
    }

    public function getFulfilledUsers() 
    {
        $users = User::where('is_fulfilled', true);
        return UserResource::collection($users);
    }
}