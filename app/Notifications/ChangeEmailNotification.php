<?php

namespace App\Notifications;

use App\Core\Mail\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
// use NbsPhp\Auth\Notifications\ResetPasswordNotification as ResetPasswordNotificationBase;

class ChangeEmailNotification extends Notification
{
    use Queueable;


    public function via()
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        //phpcs:disable
        return (new Mail)
            ->subject(__('Change Email'))
            ->markdown('frontend::email.email-verify', [ 'url' => $this->resetUrl($notifiable), 'name' => $notifiable->name])
            ->to($notifiable->getEmailForVerification(), $notifiable->getNameForVerification());
        //phpcs:enable
    }


    protected function resetUrl($notifiable)
    {
        return route('front.profile.change_email.verify', ['token' => $notifiable->user_verification->token, 'email' => $notifiable->getEmailForVerification()]);
    }
}
