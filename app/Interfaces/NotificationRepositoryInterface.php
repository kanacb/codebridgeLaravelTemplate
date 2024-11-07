<?php

namespace App\Interfaces;

interface NotificationRepositoryInterface 
{
    public function getAllNotifications();
    public function getNotificationById($notificationId);
    public function deleteNotification($notificationId);
    public function createNotification(array $notificationDetails);
    public function updateNotification($notificationId, array $newDetails);
}