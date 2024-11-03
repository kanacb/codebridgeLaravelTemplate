<?php

namespace App\Interfaces;

interface DynaFieldRepositoryInterface 
{
    public function getAllDynaFields();
    public function getDynaFieldById($dynaFieldId);
    public function deleteDynaField($dynaFieldId);
    public function createDynaField(array $dynaFieldDetails);
    public function updateDynaField($dynaFieldId, array $newDetails);
}