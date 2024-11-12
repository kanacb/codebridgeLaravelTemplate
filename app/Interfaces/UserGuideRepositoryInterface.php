<?php

namespace App\Interfaces;

interface UserGuideRepositoryInterface 
{
    public function getAllUserGuides();
    public function getUserGuideById($userGuideId);
    public function deleteUserGuide($userGuideId);
    public function createUserGuide(array $userGuideDetails);
    public function updateUserGuide($userGuideId, array $newDetails);
}