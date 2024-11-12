<?php

namespace App\Interfaces;

interface MailRepositoryInterface 
{
    public function getAllMails();
    public function getMailById($mailId);
    public function deleteMail($mailId);
    public function createMail(array $mailDetails);
    public function updateMail($mailId, array $newDetails);
}