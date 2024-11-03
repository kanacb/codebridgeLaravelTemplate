<?php

namespace App\Interfaces;

interface CompanyPhoneRepositoryInterface 
{
    public function getAllCompanyPhones();
    public function getCompanyPhoneById($companyPhoneId);
    public function deleteCompanyPhone($companyPhoneId);
    public function createCompanyPhone(array $companyPhoneDetails);
    public function updateCompanyPhone($companyPhoneId, array $newDetails);
}