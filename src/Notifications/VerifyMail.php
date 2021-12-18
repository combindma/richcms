<?php

namespace Combindma\Richcms\Notifications;

use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use URL;

class VerifyMail extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

    public function via()
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
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage())
            ->subject('Confirmez votre adresse email')
            ->markdown('emails.verifyEmail', compact('notifiable', 'verificationUrl'));
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
