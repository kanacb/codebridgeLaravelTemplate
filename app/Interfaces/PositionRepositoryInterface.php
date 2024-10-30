<?php

namespace App\Interfaces;

interface PositionRepositoryInterface 
{
    public function getAllPositions();
    public function getPositionById($positionId);
    public function deletePosition($positionId);
    public function createPosition(array $positionDetails);
    public function updatePosition($positionId, array $newDetails);
}