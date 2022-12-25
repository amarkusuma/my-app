<?php

namespace App\Notifications;

use App\Core\Mail\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }


    public function via()
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        //phpcs:disable
        return (new Mail)
            ->subject(__('Reset Password'))
            ->markdown('frontend::email.reset-password', [ 'url' => $this->resetUrl($notifiable), 'name' => $notifiable->name])
            ->to($notifiable->getEmailForVerification(), $notifiable->getNameForVerification());
        //phpcs:enable
    }


    protected function resetUrl($notifiable)
    {
        return route('api.verification', ['token' => $this->token, 'email' => $notifiable->getEmailForVerification()]);
    }
}
