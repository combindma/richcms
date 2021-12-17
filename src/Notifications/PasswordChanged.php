<?php

namespace Combindma\Richcms\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(){}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function viaQueues()
    {
        return [
            'mail' => 'email',
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Mot de passe modifié')
            ->replyTo(option()->contact_email)
            ->markdown('emails.passwordChanged', compact('notifiable'));
    }

}
