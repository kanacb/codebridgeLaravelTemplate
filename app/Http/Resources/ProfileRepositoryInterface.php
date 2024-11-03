<?php

namespace App\Interfaces;

interface ProfileRepositoryInterface 
{
    public function getAllProfiles();
    public function getProfileById($profileId);
    public function deleteProfile($profileId);
    public function createProfile(array $profileDetails);
    public function updateProfile($profileId, array $newDetails);
}