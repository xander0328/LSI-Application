<?php

namespace App\Http\Controllers;

use App\Jobs\SendPushNotification;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Enrollee;
use App\Models\DeviceToken;
use App\Services\NotificationSendService;
use Carbon\Carbon;

class NotificationSendController extends Controller
{
    protected $notificationSendService;

    public function __construct(NotificationSendService $notificationSendService)
    {
        $this->notificationSendService = $notificationSendService;
    }

    public static function sendAppNotification(Request $request)
    {
        $validated = $request->validate([
            'notification_data' => 'required|array', // Notification data should be provided
        ]);

        $notificationData = $validated['notification_data'];

        // Get the list of device tokens for the users (or a specific group, etc.)
        $deviceTokens = DeviceToken::all(); // Or filter based on specific conditions

        foreach ($deviceTokens as $deviceToken) {
            // Dispatch the job for each device token
            SendPushNotification::dispatch($deviceToken, $notificationData);
        }

        return response()->json(['message' => 'Push notifications are being sent.'], 200);
    }

    public static function sendSmsNotification($receiver, $message)
    {
        $ch = curl_init();
        $parameters = array(
            'apikey' => 'df2d7961dc3c906937aec0642009d135',
            'number' => $receiver,
            'message' => $message,
            'sendername' => 'LsiOrMin'
        );
        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);

        //Send the parameters set above with the request
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

        // Receive response from server
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        //Show the server response
        echo $output;
    }

    public static function sendEmailNotification() {}
}
