<?php

namespace App\Interfaces;

interface JobQueRepositoryInterface 
{
    public function getAllJobQues();
    public function getJobQueById($jobQueId);
    public function deleteJobQue($jobQueId);
    public function createJobQue(array $jobQueDetails);
    public function updateJobQue($jobQueId, array $newDetails);
}