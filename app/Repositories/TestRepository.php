<?php

namespace App\Repositories;

use App\Interfaces\TestRepositoryInterface;
use App\Models\Test;
use App\Http\Resources\TestResource;

class TestRepository implements TestRepositoryInterface 
{
    public function getAllTests() 
    {
        $tests = Test::all();
        return TestResource::collection($tests);
    }

    public function getTestById($TestId) 
    {
        $tests = Test::findOrFail($TestId);
        return TestResource::collection($tests);
    }

    public function deleteTest($TestId) 
    {
        Test::destroy($TestId);
    }

    public function createTest(array $TestDetails) 
    {
        return Test::create($TestDetails);
    }

    public function updateTest($TestId, array $newDetails) 
    {
        return Test::whereId($TestId)->update($newDetails);
    }

}