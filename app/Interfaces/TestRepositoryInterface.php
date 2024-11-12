<?php

namespace App\Interfaces;

interface TestRepositoryInterface 
{
    public function getAllTests();
    public function getTestById($testId);
    public function deleteTest($testId);
    public function createTest(array $testDetails);
    public function updateTest($testId, array $newDetails);
}