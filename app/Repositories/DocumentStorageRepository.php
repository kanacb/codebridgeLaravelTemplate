<?php

namespace App\Repositories;

use App\Interfaces\DocumentStorageRepositoryInterface;
use App\Models\DocumentStorage;
use App\Http\Resources\DocumentStorageResource;

class DocumentStorageRepository implements DocumentStorageRepositoryInterface 
{
    public function getAllDocumentStorages() 
    {
        $documentStorage = DocumentStorage::all();
        return DocumentStorageResource::collection($documentStorage);
    }

    public function getDocumentStorageById($DocumentStorageId) 
    {
        $documentStorage = DocumentStorage::findOrFail($DocumentStorageId);
        return DocumentStorageResource::collection($documentStorage);
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