<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignmentPost extends Notification
{
    use Queueable;

    protected $batch;
    protected $type;
    protected $assignment_id;
    /**
     * Create a new notification instance.
     */
    public function __construct($batch, $type, $assignment_id)
    {
        $this->batch = $batch;
        $this->type = $type;
        $this->assignment_id = $assignment_id;
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

    public function toBroadcast(object $notifiable): BroadcastMessage {
        return new BroadcastMessage([
            'user_id' => $notifiable->id,
            'notify' => 'assignment_update',
        ]);
    }

    public function toDatabase($notifiable){
        return [
            'subject' => 'assignment',
            'course_code' => $this->batch->course->code,
            'batch_name' => $this->batch->name,
            'type' => $this->type,
            'message' => $this->type == "new" ? "Your trainer has assigned a new task." : "Your trainer has updated an existing task.",
            'link' => route('view_assignment', $this->assignment_id)
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
