<?php

namespace App\Repositories;

use App\Interfaces\PositionRepositoryInterface;
use App\Models\Position;
use App\Http\Resources\PositionResource;

class PositionRepository implements PositionRepositoryInterface 
{
    public function getAllPositions() 
    {
        $positions = Position::all();
        return PositionResource::collection($positions);
    }

    public function getPositionById($PositionId) 
    {
        $positions = Position::findOrFail($PositionId);
        return PositionResource::collection($positions);
    }

    public function deletePosition($PositionId) 
    {
        Position::destroy($PositionId);
    }

    public function createPosition(array $PositionDetails) 
    {
        return Position::create($PositionDetails);
    }

    public function updatePosition($PositionId, array $newDetails) 
    {
        return Position::whereId($PositionId)->update($newDetails);
    }

}