<?php

namespace App\Repositories;

use App\Interfaces\DocumentStorageRepositoryInterface;
use App\Models\DocumentStorage;
use App\Http\Resources\DocumentStorageResource;

class DocumentStorageRepository implements DocumentStorageRepositoryInterface 
{
    public function getAllDocumentStorages() 
    {
        $documentStorages = DocumentStorage::all();
        return DocumentStorageResource::collection($documentStorages);
    }

    public function getDocumentStorageById($DocumentStorageId) 
    {
        $documentStorages = DocumentStorage::findOrFail($DocumentStorageId);
        return DocumentStorageResource::collection($documentStorages);
    }

    public function deleteDocumentStorage($DocumentStorageId) 
    {
        DocumentStorage::destroy($DocumentStorageId);
    }

    public function createDocumentStorage(array $DocumentStorageDetails) 
    {
        return DocumentStorage::create($DocumentStorageDetails);
    }

    public function updateDocumentStorage($DocumentStorageId, array $newDetails) 
    {
        return DocumentStorage::whereId($DocumentStorageId)->update($newDetails);
    }

}