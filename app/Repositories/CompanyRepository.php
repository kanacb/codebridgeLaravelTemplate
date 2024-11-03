<?php

namespace App\Repositories;

use App\Interfaces\CompanyRepositoryInterface;
use App\Models\Company;
use App\Http\Resources\CompanyResource;

class CompanyRepository implements CompanyRepositoryInterface 
{
    public function getAllCompanies() 
    {
        $companies = Company::all();
        return CompanyResource::collection($companies);
    }

    public function getCompanyById($CompanyId) 
    {
        $companies = Company::findOrFail($CompanyId);
        return CompanyResource::collection($companies);
    }

    public function deleteCompany($CompanyId) 
    {
        Company::destroy($CompanyId);
    }

    public function createCompany(array $CompanyDetails) 
    {
        return Company::create($CompanyDetails);
    }

    public function updateCompany($CompanyId, array $newDetails) 
    {
        return Company::whereId($CompanyId)->update($newDetails);
    }

}