<?php

namespace App\Repositories;

use App\Interfaces\ErrorLogRepositoryInterface;
use App\Models\ErrorLog;
use App\Http\Resources\ErrorLogResource;

class ErrorLogRepository implements ErrorLogRepositoryInterface 
{
    public function getAllErrorLogs() 
    {
        $errorLogs = ErrorLog::all();
        return ErrorLogResource::collection($errorLogs);
    }

    public function getErrorLogById($ErrorLogId) 
    {
        $errorLogs = ErrorLog::findOrFail($ErrorLogId);
        return ErrorLogResource::collection($errorLogs);
    }

    public function deleteErrorLog($ErrorLogId) 
    {
        ErrorLog::destroy($ErrorLogId);
    }

    public function createErrorLog(array $ErrorLogDetails) 
    {
        return ErrorLog::create($ErrorLogDetails);
    }

    public function updateErrorLog($ErrorLogId, array $newDetails) 
    {
        return ErrorLog::whereId($ErrorLogId)->update($newDetails);
    }

}