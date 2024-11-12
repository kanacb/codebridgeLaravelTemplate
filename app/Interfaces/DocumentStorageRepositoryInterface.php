<?php

namespace App\Interfaces;

interface DocumentStorageRepositoryInterface 
{
    public function getAllDocumentStorages();
    public function getDocumentStorageById($documentStorageId);
    public function deleteDocumentStorage($documentStorageId);
    public function createDocumentStorage(array $documentStorageDetails);
    public function updateDocumentStorage($documentStorageId, array $newDetails);
}