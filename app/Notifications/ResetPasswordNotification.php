<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
      //more methods: https://laravel.com/api/5.4/Illuminate/Notifications/Messages/MailMessage.html
        return (new MailMessage)
            ->greeting(__('mails.reset.greeting', ['name' => $notifiable->getNameUser() ]))
            ->subject(__('mails.reset.subject'))
            ->line(__('mails.reset.first.line'))
            ->action(__('mails.reset.button.action'),
              url(config('app.url').route('password.reset',
              $this->token, false)))
            ->line(__('mails.reset.second.line'))
            ->salutation(__('mails.reset.salutation'))
            ;
    }
}
