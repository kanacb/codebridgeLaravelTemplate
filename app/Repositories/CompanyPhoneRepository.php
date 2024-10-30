<?php

namespace App\Repositories;

use App\Interfaces\CompanyPhoneRepositoryInterface;
use App\Models\CompanyPhone;
use App\Http\Resources\CompanyPhoneResource;

class CompanyPhoneRepository implements CompanyPhoneRepositoryInterface 
{
    public function getAllCompanyPhones() 
    {
        $companyPhones = CompanyPhone::all();
        return CompanyPhoneResource::collection($companyPhones);
    }

    public function getCompanyPhoneById($CompanyPhoneId) 
    {
        $companyPhones = CompanyPhone::findOrFail($CompanyPhoneId);
        return CompanyPhoneResource::collection($companyPhones);
    }

    public function deleteCompanyPhone($CompanyPhoneId) 
    {
        CompanyPhone::destroy($CompanyPhoneId);
    }

    public function createCompanyPhone(array $CompanyPhoneDetails) 
    {
        return CompanyPhone::create($CompanyPhoneDetails);
    }

    public function updateCompanyPhone($CompanyPhoneId, array $newDetails) 
    {
        return CompanyPhone::whereId($CompanyPhoneId)->update($newDetails);
    }

}