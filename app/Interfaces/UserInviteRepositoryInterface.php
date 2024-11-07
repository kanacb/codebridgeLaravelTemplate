<?php

namespace App\Interfaces;

interface UserInviteRepositoryInterface 
{
    public function getAllUserInvites();
    public function getUserInviteById($userInviteId);
    public function deleteUserInvite($userInviteId);
    public function createUserInvite(array $userInviteDetails);
    public function updateUserInvite($userInviteId, array $newDetails);
}