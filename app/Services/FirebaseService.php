<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

// use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Exception\MessagingException;

use Google\Client;
use Google\Service\FirebaseCloudMessaging;
use Google\Service\FirebaseCloudMessaging\Message;
use Google\Service\FirebaseCloudMessaging\SendMessageRequest;
use Google\Service\FirebaseCloudMessaging\Notification;

use Exception;

class FirebaseService
{
    protected $client;
    protected $messaging;

    public function __construct()
    {
        // Initialize Google Client
        $this->client = new Client();
        $this->client->useApplicationDefaultCredentials();
        $this->client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        $this->client->setHttpClient(new \GuzzleHttp\Client(['verify' => storage_path('cacert.pem')]));
        // Initialize Firebase Messaging service
        $this->messaging = new FirebaseCloudMessaging($this->client);
    }

    public function sendNotification($deviceToken, $title, $body)
    {
        // $message = CloudMessage::withTarget('token', $deviceToken)
        //     ->withNotification(['title' => $title, 'body' => $body]);

        $message = [
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'android' => [
                'priority' => 'high',
            ],
            'apns' => [
                'headers' => [
                    'apns-priority' => '10',
                ],
            ],
            'tokens' => $deviceToken, // Multicast (array of tokens)
        ];

        try {
            $response = $this->messaging->send($message);
            return $response['successCount'];
        } catch (MessagingException $e) {
            // Handle FCM error
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            // Handle general error
            return ['error' => $e->getMessage()];
        }
    }

    public function subscribeToTopic($topic, $deviceTokens)
    {
        try {
            $response = $this->messaging->subscribeToTopic($topic, $deviceTokens);
            return "Successfully subscribed to the topic.";
        } catch (MessagingException $e) {
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function sendToTopic($topic, $title, $body)
    {
        $message = CloudMessage::withTarget('topic', $topic)
            ->withNotification([
                'title' => $title,
                'body' => $body,
            ]);

        try {
            $response = $this->messaging->send($message);
            return $response;
        } catch (MessagingException $e) {
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function sendMulticastNotification(array $deviceTokens, string $title, string $body)
    {
        $fcmEndpoint = 'https://fcm.googleapis.com/v1/projects/lsi-app-541ad/messages:send';

        foreach ($deviceTokens as $token) {
            $notification = new Notification();
            $notification->setTitle($title);
            $notification->setBody($body);

            // Create Message instance
            $message = new Message();
            $message->setToken($token);
            $message->setNotification($notification);

            // Build the SendMessageRequest
            $sendMessageRequest = new SendMessageRequest();
            $sendMessageRequest->setMessage($message);

            try {
                $response = $this->messaging->projects_messages->send('projects/lsi-app-541ad', $sendMessageRequest);
                echo 'Message sent successfully to token: ' . $token . "\n";
            } catch (Exception $e) {
                echo 'Error sending message to token: ' . $token . ' - ' . $e->getMessage() . "\n";
            }
        }
    }
}
