<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AttendanceNotif extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

     protected $batch, $type, $attendance;
    public function __construct($batch, $type, $attendance)
    {
        $this->batch = $batch;
        $this->type = $type;
        $this->attendance = $attendance;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage {
        return new BroadcastMessage([
            'user_id' => $notifiable->id,
            'notify' => 'attendance_update',

        ]);
    }

    public function toDatabase($notifiable){
        return [
            'subject' => 'attendance',
            'course_code' => $this->batch->course->code,
            'batch_name' => $this->batch->name,
            'type' => $this->type,
            'message' => $this->type == "new" ? "New attendance record ." : "Updated attendance record.",
            'link' => route('enrolled_course_attendance')
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
