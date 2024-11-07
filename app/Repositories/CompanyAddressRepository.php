<?php

namespace App\Repositories;

use App\Interfaces\CompanyAddressRepositoryInterface;
use App\Models\CompanyAddress;
use App\Http\Resources\CompanyAddressResource;

class CompanyAddressRepository implements CompanyAddressRepositoryInterface 
{
    public function getAllCompanyAddresses() 
    {
        $companyAddresses = CompanyAddress::all();
        return CompanyAddressResource::collection($companyAddresses);
    }

    public function getCompanyAddressById($CompanyAddressId) 
    {
        $companyAddresses = CompanyAddress::findOrFail($CompanyAddressId);
        return CompanyAddressResource::collection($companyAddresses);
    }

    public function deleteCompanyAddress($CompanyAddressId) 
    {
        CompanyAddress::destroy($CompanyAddressId);
    }

    public function createCompanyAddress(array $CompanyAddressDetails) 
    {
        return CompanyAddress::create($CompanyAddressDetails);
    }

    public function updateCompanyAddress($CompanyAddressId, array $newDetails) 
    {
        return CompanyAddress::whereId($CompanyAddressId)->update($newDetails);
    }

}