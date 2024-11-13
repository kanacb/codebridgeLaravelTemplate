<?php

namespace App\Interfaces;

interface LoginHistoryRepositoryInterface 
{
    public function getAllLoginHistories();
    public function getLoginHistoryById($loginHistoryId);
    public function deleteLoginHistory($loginHistoryId);
    public function createLoginHistory(array $loginHistoryDetails);
    public function updateLoginHistory($loginHistoryId, array $newDetails);
}