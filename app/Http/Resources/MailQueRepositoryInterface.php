<?php

namespace App\Interfaces;

interface MailQueRepositoryInterface 
{
    public function getAllMailQues();
    public function getMailQueById($mailQueId);
    public function deleteMailQue($mailQueId);
    public function createMailQue(array $mailQueDetails);
    public function updateMailQue($mailQueId, array $newDetails);
}