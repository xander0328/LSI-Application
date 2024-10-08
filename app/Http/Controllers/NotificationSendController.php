<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Enrollee;
use App\Models\DeviceToken;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\WebPushConfig;
use GuzzleHttp\Client;

class NotificationSendController extends Controller
{

    public function updateDeviceToken(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
        ]);

        $enrolleeExists = Enrollee::where('user_id', auth()->id())
            ->exists();

        if (!$enrolleeExists) {
            return response()->json(['message' => 'No matching enrollee found for the provided batch ID.'], 404);
        }

        $existingToken = DeviceToken::where('user_id', auth()->id())
            ->where('device_token', $request->device_token)
            ->first();

        if (!$existingToken) {
            DeviceToken::create([
                'user_id' => auth()->id(),
                'device_token' => $request->device_token,
            ]);
        }

        return response()->json(['Token successfully stored.']);
    }

    // public static function sendAppNotification($FcmToken, $title, $body, $click_action)
    // {
    //     $url = 'https://fcm.googleapis.com/v1/projects/lsi-app-541ad/messages:send';
            
    //     $serverKey = "AAAArHotyRE:APA91bGrDl-TJzEZFgdsyYXtk7UE2QMl6-ckv-QfZlLMoVi_CQ7rnZafx31ISAzsmLU3qGFNMIe2pHYwQ7nqM6JP_X-cQUsOjiuRiDk0CioJMy-D2tokNtE7TsrW2WwSTM0pLEnI75Qk";

    //     try {
    //             // Get the access token
    //             $accessToken = self::getAccessToken();
    //     } catch (\Exception $e) {
    //             // Handle token retrieval errors
    //             die('Error fetching access token: ' . $e->getMessage());
    //         }

    //         $notification = [
    //             "title" => $title,
    //             "body" => $body,
    //             'click_action' => $click_action ?? 'FLUTTER_NOTIFICATION_CLICK' 
    //         ];

    //         $data = [
    //             "registration_ids" => $FcmToken,
    //             "notification" => $notification,
    //         ];
    //         $encodedData = json_encode($data);
        
    //         $headers = [
    //             'Authorization: Bearer ' . $accessToken,
    //             'Content-Type: application/json',
    //         ];
        
    //         $ch = curl_init();
            
    //         curl_setopt($ch, CURLOPT_URL, $url);
    //         curl_setopt($ch, CURLOPT_POST, true);
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
    //         // Execute post
    //         $result = curl_exec($ch);
    //         if ($result === FALSE) {
    //             die('Curl failed: ' . curl_error($ch));
    //     }
    //     // Close connection
    //     curl_close($ch);
    //     // FCM response
    //     dd($result);
    // }

    public static function sendAppNotification($FcmToken, $title, $body, $click_action){
            $serviceAccountPath = storage_path('app/firebase/lsi-app-541ad-26454529d05e.json');

            $firebase = (new Factory)
                ->withServiceAccount(storage_path('app/firebase/lsi-app-541ad-26454529d05e.json'));

            $messaging = $firebase->createMessaging();

            $webPushConfig = [
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ]
            ];

            $message = CloudMessage::new()->withWebPushConfig($webPushConfig);
    
            // Send a multicast message to multiple devices
            try {
                $response = $messaging->sendMulticast($message, $FcmToken); // $FcmTokens is an array of device tokens
                dd($response);
                // Handle the response: check how many messages were successfully sent
                $successfulSends = $response->successes()->count();
                $failedSends = $response->failures()->count();
    
                return response()->json([
                    'message' => "Web Push Notification sent to $successfulSends devices.",
                    'failed' => $failedSends
                ]);
            } catch (MessagingException $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
    }

    public static function sendSmsNotification($receiver, $message){
        $ch = curl_init();
        $parameters = array(
            'apikey' => 'df2d7961dc3c906937aec0642009d135',
            'number' => $receiver,
            'message' => $message,
            'sendername' => 'LsiOrMin'
        );
        curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
        curl_setopt( $ch, CURLOPT_POST, 1 );

        //Send the parameters set above with the request
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

        // Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close ($ch);

        //Show the server response
        echo $output;
    }

    public static function sendEmailNotification(){
        
    }

}
