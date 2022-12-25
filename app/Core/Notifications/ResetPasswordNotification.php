<?php

namespace App\Core\Notifications;

use App\Core\Mail\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    private $token;

    /**
     * Create a notification instance.
     *
     * @param string $token
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification channels.
     *
     * @return array|string
     */
    public function via()
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return Mail
     */
    public function toMail($notifiable)
    {
        //phpcs:disable
        return (new Mail)
            ->subject(__('Reset Password'))
            ->greeting(__("Hello, ") . $notifiable->getNameForPasswordReset())
            ->line(__('You recently requested to reset your password for account, Click the button below to reset it'))
            ->action(__('Reset Password'), $this->resetUrl($notifiable), [
                'bottom' => [
                    __('If you did not request a password reset, please ignore this email.'),
                    __('This password reset is only valid for the next :count minutes.', [
                        'count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire'),
                    ]),
                ],
            ])
            ->to($notifiable->getEmailForPasswordReset(), $notifiable->getNameForPasswordReset());
        //phpcs:enable
    }

    /**
     * Get the reset URL for the given notifiable.
     *
     * @param mixed $notifiable
     *
     * @return string
     */
    protected function resetUrl($notifiable)
    {
        return route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()]);
    }
}
