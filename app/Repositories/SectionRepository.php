<?php

namespace App\Repositories;

use App\Interfaces\SectionRepositoryInterface;
use App\Models\Section;
use App\Http\Resources\SectionResource;

class SectionRepository implements SectionRepositoryInterface 
{
    public function getAllSections() 
    {
        $sections = Section::all();
        return SectionResource::collection($sections);
    }

    public function getSectionById($SectionId) 
    {
        $sections = Section::findOrFail($SectionId);
        return SectionResource::collection($sections);
    }

    public function deleteSection($SectionId) 
    {
        Section::destroy($SectionId);
    }

    public function createSection(array $SectionDetails) 
    {
        return Section::create($SectionDetails);
    }

    public function updateSection($SectionId, array $newDetails) 
    {
        return Section::whereId($SectionId)->update($newDetails);
    }

}