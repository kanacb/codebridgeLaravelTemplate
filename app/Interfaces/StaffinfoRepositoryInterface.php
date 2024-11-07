<?php

namespace App\Interfaces;

interface StaffinfoRepositoryInterface 
{
    public function getAllStaffinfos();
    public function getStaffinfoById($staffinfoId);
    public function deleteStaffinfo($staffinfoId);
    public function createStaffinfo(array $staffinfoDetails);
    public function updateStaffinfo($staffinfoId, array $newDetails);
}