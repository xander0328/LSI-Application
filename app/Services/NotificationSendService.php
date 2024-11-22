<?php

namespace App\Services;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\Messaging\InvalidMessage;
use Kreait\Firebase\Exception\Messaging\RegistrationTokenNotRegistered;


class NotificationSendService
{
    protected $messaging;

    public function __construct()
    {
        // Initialize Firebase Factory
        $this->messaging = (new Factory)->createMessaging();
    }

    public function sendPushNotification(string $deviceToken, string $title, string $body, array $data = [])
    {
        // Create a message object
        $message = CloudMessage::withTarget(CloudMessage::TOKEN, $deviceToken)
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        try {
            // Send the message
            $response = $this->messaging->send($message);

            return $response;
        } catch (InvalidMessage $e) {
            // Handle invalid message error
            return ['error' => 'Invalid message', 'message' => $e->getMessage()];
        } catch (RegistrationTokenNotRegistered $e) {
            // Handle case when registration token is no longer valid
            return ['error' => 'Registration token not registered', 'message' => $e->getMessage()];
        }
    }
}
