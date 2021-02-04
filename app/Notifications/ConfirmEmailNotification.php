<?php

namespace App\Notifications;

use App\Models\EmailConfirm;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmEmailNotification extends Notification
{
    use Queueable;

    protected $emailConfirm;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(EmailConfirm $emailConfirm)
    {
        $this->emailConfirm = $emailConfirm;
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
        ->subject('Confirm email')
        ->greeting('Hello ' . $notifiable->firstname . " " . $notifiable->lastname . ",")
        ->line('To confirm your email, please click on the following button')
        ->action('Confirm email', route('confirm_email', ['token' => $this->emailConfirm->token ]))
        ->line('Thank you for using our application!');
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
