<?php

namespace App\Notifications;

use App\Core\Mail\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SendOTPLoginNotification extends Notification
{
    use Queueable;

    // private $kode_otp;
    // public function __construct($otp)
    // {
    //     $this->kode_otp = $otp;
    // }


    public function via()
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        //phpcs:disable
        return (new Mail)
            ->subject(__('Kode OTP Login'))
            ->markdown('email.email-otp-login', [ 'kode_otp' => $notifiable->otp_code, 'name' => $notifiable->name])
            ->to($notifiable->getEmailForVerification(), $notifiable->getNameForVerification());
        //phpcs:enable
    }
}
