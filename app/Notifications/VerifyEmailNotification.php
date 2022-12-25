<?php

namespace App\Notifications;

use App\Core\Mail\Mail;
use App\Core\Notifications\VerifyEmailNotification as NotificationsVerifyEmailNotification;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends NotificationsVerifyEmailNotification
{

    public function toMail($notifiable)
    {
        return (new Mail)
            ->subject(__('Mohon Verifikasi Email Akun!'))
            ->markdown('email.email-verify', [ 'url' => $this->verificationUrl($notifiable), 'name' => $notifiable->name])
            // ->greeting(__("Selamat!"))
            // ->line(__('Terima kasih sudah melakukan registrasi'))
            // ->line(__('Untuk melanjutkan aktivitas, silahkan klik tombol di bawah untuk'))
            // ->line(__('melakukan aktivasi akunmu'))
            // ->action(__('Verifikasi Email'), $this->verificationUrl($notifiable), [
            //     'bottom' => [
            //         __('Jika anda tidak melakukan registrasi, mohon abaikan email ini'),
            //     ],
            // ])
            // ->line(__('Email ini dibuat secara otomatis, mohon jangan balas email ini.'), 'outroLines')
            ->to($notifiable->getEmailForVerification(), $notifiable->getNameForVerification());
    }


    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'backend.verification',
            now()->addHours(24),
            [
                // 'id' => encrypt($notifiable->getKey()),
                'email' => $notifiable->getEmailForVerification(),
                'token' => $notifiable->remember_token,
                'redirectTo' => url('/'),
            ]
        );
    }
}
