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
                    ->line('You have ' . $this->numberDue . ' cards due for Memory Maintenance.')
                    ->action('Start Review', url('/my-sets'))
                    ->line('Remember: testing yourself and spacing your study over time helps form stronger memories.')
                    ->line('Thank you for using StemmaStudy!');
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
