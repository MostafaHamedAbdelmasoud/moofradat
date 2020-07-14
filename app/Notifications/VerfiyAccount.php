<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class VerfiyAccount extends Notification
{
    use Queueable, SerializesModels;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('تفعيل الحساب الشخصي')
            ->line('مرحبا بك, قم بتفعيل حساب حتى يتم السماح لك بالقيام بمهامك.')
            ->from('support@moofradat.com', 'Support Moofradat')
            ->action('لتفعيل إضغط هنا', url('/ipanel/verifed/' . $this->user->email . '/' . $this->user->id))
            ->line('تحياتنا موقع مفردات. مع تحيات مبرمج التطبيق.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
