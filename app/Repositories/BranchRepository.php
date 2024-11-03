<?php

namespace App\Repositories;

use App\Interfaces\BranchRepositoryInterface;
use App\Models\Branch;
use App\Http\Resources\BranchResource;

class BranchRepository implements BranchRepositoryInterface
{
    public function getAllBranches()
    {
        $branches = Branch::all();
        return BranchResource::collection($branches);
    }

    public function getBranchById($BranchId)
    {
        $branches = Branch::findOrFail($BranchId);
        return BranchResource::collection($branches);
    }

    public function deleteBranch($BranchId)
    {
        Branch::destroy($BranchId);
    }

    public function createBranch(array $BranchDetails)
    {
        return Branch::create($BranchDetails);
    }

    public function updateBranch($BranchId, array $newDetails)
    {
        return Branch::whereId($BranchId)->update($newDetails);
    }
}
