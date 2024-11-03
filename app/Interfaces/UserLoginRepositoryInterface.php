<?php

namespace App\Interfaces;

interface UserLoginRepositoryInterface 
{
    public function getAllUserLogins();
    public function getUserLoginById($userLoginId);
    public function deleteUserLogin($userLoginId);
    public function createUserLogin(array $userLoginDetails);
    public function updateUserLogin($userLoginId, array $newDetails);
}