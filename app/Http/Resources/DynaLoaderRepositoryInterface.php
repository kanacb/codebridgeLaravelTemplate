<?php

namespace App\Interfaces;

interface DynaLoaderRepositoryInterface 
{
    public function getAllDynaLoaders();
    public function getDynaLoaderById($dynaLoaderId);
    public function deleteDynaLoader($dynaLoaderId);
    public function createDynaLoader(array $dynaLoaderDetails);
    public function updateDynaLoader($dynaLoaderId, array $newDetails);
}