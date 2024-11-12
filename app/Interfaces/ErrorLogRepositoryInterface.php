<?php

namespace App\Interfaces;

interface ErrorLogRepositoryInterface 
{
    public function getAllErrorLogs();
    public function getErrorLogById($errorLogId);
    public function deleteErrorLog($errorLogId);
    public function createErrorLog(array $errorLogDetails);
    public function updateErrorLog($errorLogId, array $newDetails);
}