<?php

namespace App\Repositories;

use App\Interfaces\UserAddressRepositoryInterface;
use App\Models\UserAddress;
use App\Http\Resources\UserAddressResource;

class UserAddressRepository implements UserAddressRepositoryInterface 
{
    public function getAllUserAddresses() 
    {
        $userAddresses = UserAddress::all();
        return UserAddressResource::collection($userAddresses);
    }

    public function getUserAddressById($UserAddressId) 
    {
        $userAddresses = UserAddress::findOrFail($UserAddressId);
        return UserAddressResource::collection($userAddresses);
    }

    public function deleteUserAddress($UserAddressId) 
    {
        UserAddress::destroy($UserAddressId);
    }

    public function createUserAddress(array $UserAddressDetails) 
    {
        return UserAddress::create($UserAddressDetails);
    }

    public function updateUserAddress($UserAddressId, array $newDetails) 
    {
        return UserAddress::whereId($UserAddressId)->update($newDetails);
    }

}