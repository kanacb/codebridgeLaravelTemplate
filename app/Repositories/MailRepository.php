<?php

namespace App\Repositories;

use App\Interfaces\MailRepositoryInterface;
use App\Models\Mail;
use App\Http\Resources\MailResource;

class MailRepository implements MailRepositoryInterface 
{
    public function getAllMails() 
    {
        $mails = Mail::all();
        return MailResource::collection($mails);
    }

    public function getMailById($MailId) 
    {
        $mails = Mail::findOrFail($MailId);
        return MailResource::collection($mails);
    }

    public function deleteMail($MailId) 
    {
        Mail::destroy($MailId);
    }

    public function createMail(array $MailDetails) 
    {
        return Mail::create($MailDetails);
    }

    public function updateMail($MailId, array $newDetails) 
    {
        return Mail::whereId($MailId)->update($newDetails);
    }

}