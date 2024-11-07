<?php

namespace App\Interfaces;

interface CompanyRepositoryInterface 
{
    public function getAllCompanies();
    public function getCompanyById($companyId);
    public function deleteCompany($companyId);
    public function createCompany(array $companyDetails);
    public function updateCompany($companyId, array $newDetails);
}