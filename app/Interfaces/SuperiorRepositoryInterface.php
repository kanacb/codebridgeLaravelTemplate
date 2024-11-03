<?php

namespace App\Interfaces;

interface SuperiorRepositoryInterface 
{
    public function getAllSuperiors();
    public function getSuperiorById($superiorId);
    public function deleteSuperior($superiorId);
    public function createSuperior(array $superiorDetails);
    public function updateSuperior($superiorId, array $newDetails);
}