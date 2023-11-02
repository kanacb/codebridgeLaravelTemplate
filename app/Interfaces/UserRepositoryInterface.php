<?php

namespace App\Interfaces;

interface UserRepositoryInterface 
{
    public function getAllUsers();
    public function getUserById($UserId);
    public function deleteUser($UserId);
    public function createUser(array $UserDetails);
    public function updateUser($UserId, array $newDetails);
    public function getFulfilledUsers();
}