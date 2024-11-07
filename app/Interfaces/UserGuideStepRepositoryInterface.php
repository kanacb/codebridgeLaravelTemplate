<?php

namespace App\Interfaces;

interface UserGuideStepRepositoryInterface 
{
    public function getAllUserGuideSteps();
    public function getUserGuideStepById($userGuideStepId);
    public function deleteUserGuideStep($userGuideStepId);
    public function createUserGuideStep(array $userGuideStepDetails);
    public function updateUserGuideStep($userGuideStepId, array $newDetails);
}