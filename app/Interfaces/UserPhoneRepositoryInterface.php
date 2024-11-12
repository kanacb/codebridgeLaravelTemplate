<?php

namespace App\Interfaces;

interface UserPhoneRepositoryInterface 
{
    public function getAllUserPhones();
    public function getUserPhoneById($userPhoneId);
    public function deleteUserPhone($userPhoneId);
    public function createUserPhone(array $userPhoneDetails);
    public function updateUserPhone($userPhoneId, array $newDetails);
}