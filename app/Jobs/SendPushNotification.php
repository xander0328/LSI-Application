<?php

namespace App\Jobs;

use App\Models\DeviceToken;
use App\Notifications\PushNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

class SendPushNotification implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    protected $deviceToken;
    protected $notificationData;

    /**
     * Create a new job instance.
     *
     * @param  DeviceToken  $deviceToken
     * @param  array  $notificationData
     * @return void
     */
    public function __construct(DeviceToken $deviceToken, array $notificationData)
    {
        $this->deviceToken = $deviceToken;
        $this->notificationData = $notificationData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // Get the device token
            $deviceToken = $this->deviceToken->device_token;

            // Create the message for FCM
            $message = CloudMessage::new()
                ->withTarget('token', $deviceToken) // Target device
                ->withNotification(FirebaseNotification::create(
                    $this->notificationData['title'],  // Notification title
                    $this->notificationData['message'] // Notification body
                ));

            // Send the push notification using Firebase
            $messaging = app('firebase.messaging');
            $messaging->send($message);
        } catch (\Exception $e) {
            \Log::error("Error sending push notification: " . $e->getMessage());
        }
    }
}
