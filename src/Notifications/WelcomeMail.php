<?php

namespace Combindma\Richcms\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeMail extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

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
        return (new MailMessage())
            ->subject('Bienvenue sur '.config('app.name'))
            ->replyTo(option()->contact_email)
            ->markdown('emails.welcome', compact('notifiable'));
    }
}
