<?php

namespace App\Repositories;

use App\Interfaces\MailQueRepositoryInterface;
use App\Models\MailQue;
use App\Http\Resources\MailQueResource;

class MailQueRepository implements MailQueRepositoryInterface 
{
    public function getAllMailQues() 
    {
        $mailQues = MailQue::all();
        return MailQueResource::collection($mailQues);
    }

    public function getMailQueById($MailQueId) 
    {
        $mailQues = MailQue::findOrFail($MailQueId);
        return MailQueResource::collection($mailQues);
    }

    public function deleteMailQue($MailQueId) 
    {
        MailQue::destroy($MailQueId);
    }

    public function createMailQue(array $MailQueDetails) 
    {
        return MailQue::create($MailQueDetails);
    }

    public function updateMailQue($MailQueId, array $newDetails) 
    {
        return MailQue::whereId($MailQueId)->update($newDetails);
    }

}