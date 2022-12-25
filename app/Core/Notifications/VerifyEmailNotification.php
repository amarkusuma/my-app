<?php

namespace App\Core\Notifications;

use App\Core\Mail\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    public function via()
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new Mail)
            ->subject('Email Verification')
            ->action(__('Confirmation'), $this->verificationUrl($notifiable))
            ->to($notifiable->getEmailForVerification(), $notifiable->getNameForVerification());
    }


    protected function verificationUrl($notifiable)
    {
        return "URL?token={$notifiable->getKey()}";
    }
}
