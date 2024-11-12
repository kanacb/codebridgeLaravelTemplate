<?php

namespace App\Interfaces;

interface BranchRepositoryInterface 
{
    public function getAllBranches();
    public function getBranchById($branchId);
    public function deleteBranch($branchId);
    public function createBranch(array $branchDetails);
    public function updateBranch($branchId, array $newDetails);
}