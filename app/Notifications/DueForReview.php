<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DueForReview extends Notification
{
    use Queueable;

    private $numberDue = 0;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($numDue)
    {
        $this->numberDue = $numDue;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your Connected Flashcards are Ready for Review.')
                    ->greeting("Hello!")
                    ->line('You have ' . $this->numberDue . ' card'  . ($this->numberDue > 1 ? 's' :'' ) . ' due for Memory Maintenance.')
                    ->action('Start Review', url('/my-sets'))
                    ->line("Remember: testing yourself and spacing your study over time isn't just a good habit - it has been proven to help form stronger memories.")
                    ->line("Thank you for using StemmaStudy! To manage your receipt of these notifications, visit your account Settings.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
