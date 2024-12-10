<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class PostNotif extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    protected $post_id;
    protected $batch;
    protected $type;
    /**
     * Create a new notification instance.
     */
    public function __construct($post_id, $batch, $type)
    {
        $this->post_id = $post_id;
        $this->batch = $batch;
        $this->type = $type;
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
            'notify' => 'post_update',

        ]);
    }

    public function toDatabase($notifiable){
        return [
            'subject' => 'post',
            'course_code' => $this->batch->course->code,
            'batch_name' => $this->batch->name,
            'type' => $this->type,
            'message' => $this->type == "new" ? "Your trainer has posted a new update." : "Your trainer has updated a post in the stream.",
            'link' => route('student.comments', ['batch_id' => $this->batch->id, 'post_id' => $this->post_id])
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
