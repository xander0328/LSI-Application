<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

class PushNotification extends Notification
{
    protected $notificationData;

    /**
     * Create a new notification instance.
     *
     * @param  array  $notificationData
     * @return void
     */
    public function __construct(array $notificationData)
    {
        $this->notificationData = $notificationData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Return the channels through which the notification will be sent (e.g., 'database', 'fcm', etc.)
        return ['database', 'fcm'];  // Assuming you're sending notifications through Firebase Cloud Messaging (FCM)
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->notificationData;
    }

    /**
     * Send push notification via FCM (if you're using FCM).
     *
     * @param  mixed  $notifiable
     * @return void
     */
    public function toFcm($notifiable)
    {
        $deviceToken = $notifiable->routeNotificationForFcm();

        // Create the message
        $message = CloudMessage::new()
            ->withTarget('token', $deviceToken) // Specify the target device
            ->withNotification(FirebaseNotification::create(
                $this->notificationData['title'],  // Title of the notification
                $this->notificationData['message']  // Message body of the notification
            ));

        // Send the message
        $messaging = app('firebase.messaging');
        $messaging->send($message);
    }
}
