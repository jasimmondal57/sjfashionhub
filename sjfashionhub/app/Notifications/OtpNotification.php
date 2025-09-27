<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpNotification extends Notification
{
    use Queueable;

    protected $otp;
    protected $purpose;

    /**
     * Create a new notification instance.
     */
    public function __construct($otp, $purpose)
    {
        $this->otp = $otp;
        $this->purpose = $purpose;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $purposeText = [
            'registration' => 'complete your registration',
            'login' => 'login to your account',
            'password_reset' => 'reset your password',
        ];

        $actionText = $purposeText[$this->purpose] ?? 'verify your account';

        return (new MailMessage)
            ->subject('Your SJ Fashion Hub Verification Code')
            ->greeting('Hello!')
            ->line("Your verification code is: **{$this->otp}**")
            ->line("Use this code to {$actionText}.")
            ->line('This code will expire in 10 minutes.')
            ->line('If you did not request this code, please ignore this email.')
            ->salutation('Best regards, SJ Fashion Hub Team');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'otp' => $this->otp,
            'purpose' => $this->purpose,
        ];
    }
}
