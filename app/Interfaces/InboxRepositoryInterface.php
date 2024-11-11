<?php

namespace App\Interfaces;

interface InboxRepositoryInterface 
{
    public function getAllInboxes();
    public function getInboxById($inboxId);
    public function deleteInbox($inboxId);
    public function createInbox(array $inboxDetails);
    public function updateInbox($inboxId, array $newDetails);
}