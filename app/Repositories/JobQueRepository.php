<?php

namespace App\Repositories;

use App\Interfaces\JobQueRepositoryInterface;
use App\Models\JobQue;
use App\Http\Resources\JobQueResource;

class JobQueRepository implements JobQueRepositoryInterface 
{
    public function getAllJobQues() 
    {
        $jobQues = JobQue::all();
        return JobQueResource::collection($jobQues);
    }

    public function getJobQueById($JobQueId) 
    {
        $jobQues = JobQue::findOrFail($JobQueId);
        return JobQueResource::collection($jobQues);
    }

    public function deleteJobQue($JobQueId) 
    {
        JobQue::destroy($JobQueId);
    }

    public function createJobQue(array $JobQueDetails) 
    {
        return JobQue::create($JobQueDetails);
    }

    public function updateJobQue($JobQueId, array $newDetails) 
    {
        return JobQue::whereId($JobQueId)->update($newDetails);
    }

}