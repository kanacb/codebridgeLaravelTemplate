<?php

namespace App\Repositories;

use App\Interfaces\InboxRepositoryInterface;
use App\Models\Inbox;
use App\Http\Resources\InboxResource;

class InboxRepository implements InboxRepositoryInterface 
{
    public function getAllInboxes() 
    {
        $inbox = Inbox::all();
        return InboxResource::collection($inbox);
    }

    public function getInboxById($InboxId) 
    {
        $inbox = Inbox::findOrFail($InboxId);
        return InboxResource::collection($inbox);
    }

    public function deleteInbox($InboxId) 
    {
        Inbox::destroy($InboxId);
    }

    public function createInbox(array $InboxDetails) 
    {
        return Inbox::create($InboxDetails);
    }

    public function updateInbox($InboxId, array $newDetails) 
    {
        return Inbox::whereId($InboxId)->update($newDetails);
    }

}