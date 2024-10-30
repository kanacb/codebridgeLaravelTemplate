<?php

namespace App\Repositories;

use App\Interfaces\TemplateRepositoryInterface;
use App\Models\Template;
use App\Http\Resources\TemplateResource;

class TemplateRepository implements TemplateRepositoryInterface 
{
    public function getAllTemplates() 
    {
        $templates = Template::all();
        return TemplateResource::collection($templates);
    }

    public function getTemplateById($TemplateId) 
    {
        $templates = Template::findOrFail($TemplateId);
        return TemplateResource::collection($templates);
    }

    public function deleteTemplate($TemplateId) 
    {
        Template::destroy($TemplateId);
    }

    public function createTemplate(array $TemplateDetails) 
    {
        return Template::create($TemplateDetails);
    }

    public function updateTemplate($TemplateId, array $newDetails) 
    {
        return Template::whereId($TemplateId)->update($newDetails);
    }

}