<?php

namespace App\Repositories;

use App\Interfaces\UserPhoneRepositoryInterface;
use App\Models\UserPhone;
use App\Http\Resources\UserPhoneResource;

class UserPhoneRepository implements UserPhoneRepositoryInterface 
{
    public function getAllUserPhones() 
    {
        $userPhones = UserPhone::all();
        return UserPhoneResource::collection($userPhones);
    }

    public function getUserPhoneById($UserPhoneId) 
    {
        $userPhones = UserPhone::findOrFail($UserPhoneId);
        return UserPhoneResource::collection($userPhones);
    }

    public function deleteUserPhone($UserPhoneId) 
    {
        UserPhone::destroy($UserPhoneId);
    }

    public function createUserPhone(array $UserPhoneDetails) 
    {
        return UserPhone::create($UserPhoneDetails);
    }

    public function updateUserPhone($UserPhoneId, array $newDetails) 
    {
        return UserPhone::whereId($UserPhoneId)->update($newDetails);
    }

}