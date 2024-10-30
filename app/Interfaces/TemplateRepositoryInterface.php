<?php

namespace App\Interfaces;

interface TemplateRepositoryInterface 
{
    public function getAllTemplates();
    public function getTemplateById($templateId);
    public function deleteTemplate($templateId);
    public function createTemplate(array $templateDetails);
    public function updateTemplate($templateId, array $newDetails);
}