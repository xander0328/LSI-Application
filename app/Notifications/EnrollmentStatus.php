<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnrollmentStatus extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $status;
    protected $batchName;
    protected $courseName;

    /**
     * Create a new notification instance.
     *
     * @param string $status
     * @param string $courseName
     * @param string|null $batchName
     * @return void
     */
    public function __construct($status, $batchName = null, $courseName)
    {
        $this->status = $status;
        $this->batchName = $batchName;
        $this->courseName = $courseName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        if ($this->status == 'accepted') {
            return (new MailMessage)
                ->subject('Enrollment Status: Accepted to the Course')
                ->greeting('Congratulations!')
                ->line("You have been accepted to the course. Your batch name is: **{$this->batchName}**.")
                ->line('For now, you will need to wait for further announcements like the orientation schedule.')
                ->line('In the meantime, you can download your ID card from your profile.')
                ->line('For any queries, feel free to contact us via:')
                ->line('Facebook: [LSI Oriental Mindoro](https://facebook.com/ourpage)')
                ->action('Go to Profile', url('/profile/'))
                ->line('We look forward to seeing you in the course!');
        } else {
            return (new MailMessage)
                ->subject('Enrollment Status: Denied')
                ->greeting('We regret to inform you')
                ->line("Unfortunately, your enrollment has been denied.")
                ->line('Please feel free to reach out for clarification or re-apply in the future.')
                ->line('You can contact us via email or Facebook for more details.')
                ->line('Facebook: [LSI Oriental Mindoro](https://facebook.com/ourpage)')
                ->action('Contact Support', url('/support'))
                ->line('We wish you the best in your future endeavors.');
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable)
    {
        if ($this->status == 'accepted') {
            return [
                'status' => $this->status,
                'subject' => 'enrollment',
                'course_name' => $this->courseName,
                'batch_name' => $this->batchName,
                'message' => "You have been accepted to the {$this->courseName}. Batch: {$this->batchName}. Please wait for further announcements.",
                'id_card_link' => url('/profile/id_card/'.$notifiable->id),
            ];
        } else {
            return [
                'status' => $this->status,
                'subject' => 'enrollment',
                'course_name' => $this->courseName,
                'batch_name' => null, // No batch name if denied
                'message' => 'Your enrollment has been denied. Please contact us for further details.',
            ];
        }
    }
}
