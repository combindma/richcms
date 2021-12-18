<?php

namespace Combindma\Richcms\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAccount extends Notification implements ShouldQueue
{
    use Queueable;

    public $password;

    public function __construct($password)
    {
        $this->password = $password;
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
        $password = $this->password;

        return (new MailMessage())
            ->subject('Bienvenue à ' . config('app.name'))
            ->replyTo(option()->contact_email)
            ->markdown('emails.newAccount', compact('notifiable', 'password'));
    }
}
