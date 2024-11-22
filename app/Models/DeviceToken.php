<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    use HasFactory;

    protected $fillable = ['device_token', 'user_id', 'last_used_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the method that will route notifications to FCM.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function routeNotificationForFcm($notifiable)
    {
        return $this->device_token;  // Return the device token
    }
}
