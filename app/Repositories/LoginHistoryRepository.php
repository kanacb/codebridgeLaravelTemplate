<?php

namespace App\Repositories;

use App\Interfaces\LoginHistoryRepositoryInterface;
use App\Models\LoginHistory;
use App\Http\Resources\LoginHistoryResource;

class LoginHistoryRepository implements LoginHistoryRepositoryInterface 
{
    public function getAllLoginHistories() 
    {
        $loginHistory = LoginHistory::all();
        return LoginHistoryResource::collection($loginHistory);
    }

    public function getLoginHistoryById($LoginHistoryId) 
    {
        $loginHistory = LoginHistory::findOrFail($LoginHistoryId);
        return LoginHistoryResource::collection($loginHistory);
    }

    public function deleteLoginHistory($LoginHistoryId) 
    {
        LoginHistory::destroy($LoginHistoryId);
    }

    public function createLoginHistory(array $LoginHistoryDetails) 
    {
        return LoginHistory::create($LoginHistoryDetails);
    }

    public function updateLoginHistory($LoginHistoryId, array $newDetails) 
    {
        return LoginHistory::whereId($LoginHistoryId)->update($newDetails);
    }

}