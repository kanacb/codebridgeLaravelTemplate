<?php

namespace App\Interfaces;

interface CompanyAddressRepositoryInterface 
{
    public function getAllCompanyAddresses();
    public function getCompanyAddressById($companyAddressId);
    public function deleteCompanyAddress($companyAddressId);
    public function createCompanyAddress(array $companyAddressDetails);
    public function updateCompanyAddress($companyAddressId, array $newDetails);
}