<?php

namespace App\Repositories;

use App\Interfaces\NotificationRepositoryInterface;
use App\Models\Notification;
use App\Http\Resources\NotificationResource;

class NotificationRepository implements NotificationRepositoryInterface 
{
    public function getAllNotifications() 
    {
        $notifications = Notification::all();
        return NotificationResource::collection($notifications);
    }

    public function getNotificationById($NotificationId) 
    {
        $notifications = Notification::findOrFail($NotificationId);
        return NotificationResource::collection($notifications);
    }

    public function deleteNotification($NotificationId) 
    {
        Notification::destroy($NotificationId);
    }

    public function createNotification(array $NotificationDetails) 
    {
        return Notification::create($NotificationDetails);
    }

    public function updateNotification($NotificationId, array $newDetails) 
    {
        return Notification::whereId($NotificationId)->update($newDetails);
    }

}