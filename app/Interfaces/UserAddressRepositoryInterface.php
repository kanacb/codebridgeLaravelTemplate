<?php

namespace App\Interfaces;

interface UserAddressRepositoryInterface 
{
    public function getAllUserAddresses();
    public function getUserAddressById($userAddressId);
    public function deleteUserAddress($userAddressId);
    public function createUserAddress(array $userAddressDetails);
    public function updateUserAddress($userAddressId, array $newDetails);
}