<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\DeviceToken;

class NotificationSendController extends Controller
{
    public function updateDeviceToken(Request $request)
    {
        // $device_token = DeviceToken::where('user_id', auth()->user()->id)->get();
        $user = Auth::user();
        $user->device_tokens()->updateOrCreate(
            ['device_token' => $request->device_token],
        );

        return response()->json(['Token successfully stored.']);
    }

    public static function sendAppNotification($FcmToken, $title, $body, $click_action)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
            
        $serverKey = $_ENV('FIREBASE_SERVER_KEY');
    
        $notification = [
            "title" => $title,
            "body" => $body,
        ];
        
        if ($click_action) {
            $notification['click_action'] = $click_action;
        }

        $data = [
            "registration_ids" => $FcmToken,
            "notification" => $notification,
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response
        // dd($result);
    }

    public static function sendSmsNotification($receiver, $message){
        $ch = curl_init();
        $parameters = array(
            'apikey' => 'df2d7961dc3c906937aec0642009d135',
            'number' => $receiver,
            'message' => $message,
            'sendername' => 'SEMAPHORE'
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

}
